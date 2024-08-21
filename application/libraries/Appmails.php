<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appmails {

    protected $ci = '';

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function password_reset(Array $data, Array $user)
    {
        $email_template = $this->ci->generalmodel->get(EMAIL_TEMPLATE_TABLE, 'subject, template_content', ['name' => 'forgot-password']);
        $subject = !empty($email_template['subject']) ? $email_template['subject'] : "Password reset link : ".APP_NAME;

        $content = $email_template['template_content'];

        $content =  str_replace('[User]', $user['first_name'].' '.$user['last_name'], $content);
        $content =  str_replace('[Email]', $user['email'], $content);
        $content =  str_replace('[Password Reset Link]', $data['link'], $content);

        $data['content'] = $content;

        return $this->send_email($user['email'], $data, $subject);
    }

    private function send_email($email, $data, $subject, $config = 'info', $pdf='')
	{
        $creds = $this->ci->config->item('emails')[$config];

        $this->ci->load->library('email');
        $this->ci->email->initialize($creds);
        $this->ci->email->clear(TRUE);

        $from = $this->ci->generalmodel->check(GENERAL_SETTINGS_TABLE, ['setting_key' => 'from-email'], 'setting_value');

        if(!empty($from)){
            $this->ci->email->from($from, APP_NAME);
        }else{
            $this->ci->email->from('crm@gogotripsus.com', APP_NAME);
        }

        $toEmail = $this->ci->generalmodel->check(GENERAL_SETTINGS_TABLE, ['setting_key' => 'to-email'], 'setting_value');

        $to_email = !empty($toEmail) ? $toEmail : $email;

        $this->ci->email->to($to_email);

        $ccEmail = $this->ci->generalmodel->check(GENERAL_SETTINGS_TABLE, ['setting_key' => 'cc-email'], 'setting_value');

        if($ccEmail) {
            $this->ci->email->cc($ccEmail);
        }

		$this->ci->email->subject($subject);

        $message = $this->ci->load->view('emails/template', $data, true);

		$this->ci->email->message($message);

		if ($pdf) {
            if(is_array($pdf)) {
                foreach ($pdf as $file) {
                    if(is_file($file)) {
                        $this->ci->email->attach($_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]) . $file);
                    }
                }
            } else {
                if(is_file($pdf)) {
                    $this->ci->email->attach($_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]) . $pdf);
                }
            }
        }

        $emailSent = $this->ci->email->send(FALSE);

        $mailData = [
            'attachment'    => '',
            'to_email'      => $email,
            'cc_email'      => $ccEmail,
            'subject'       => $subject,
            'email_content' => $message,
            'status'        => $emailSent ? 'Sent' : 'Failed',
            'email_log'     => $this->ci->email->print_debugger(array('headers')),
        ];

        $query = $this->ci->generalmodel->add($mailData, EMAIL_LOGS_TABLE);

        $this->ci->email->clear();

        return;
	}
}