<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Forgot_password extends MY_Controller
{
    protected $table = USERS_TABLE;

    public function index()
    {
        if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('email', 'Email address', 'required|max_length[100]'.($this->input->cookie('dev') ? '' : '|valid_email'), [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed for %s",
                'valid_email' => "Please enter a valid %s.",
            ]);

            if ($this->form_validation->run() == FALSE) {
                $response = ['error' => true, 'message' => $this->form_validation->error_array(), 'validate' => true];
            } else {
                $post = [
                    'email'   	  => $this->input->post('email')
                ];

                if ($user = $this->generalmodel->get($this->table, 'id, email, first_name, last_name', $post)) {
                    $hp = encr_password(e_id($user['id']));
                    
                    $update = [
                        'pass_salt'  => $hp['salt'],
                        'pass_token' => $hp['hashedPassword'],
                        'updated_at'  => date('Y-m-d H:i:s', strtotime('+5 minutes')),
                    ];

                    if ($this->generalmodel->update(['id' => $user['id']], $update, $this->table)) {
                        $this->load->library('appmails');
                        $token = e_id($user['id']);

                        $update['link'] = base_url(admin("change-password/{$token}"));
    
                        $this->appmails->password_reset($update, $user);

                        $response = ['error' => true, 'message' => 'Email send to '.$user['email'].'. Check mail.'];
                    }else{
                        $response = ['error' => true, 'message' => 'Some error occurs while sending email. Try again.'];
                    }
                }else{
                    $response = ['error' => true, 'message' => 'Email address not registered or account blocked.'];
                }
            }

            die(json_encode($response));
        } else{
            $data['title'] = 'Forgot Password';
            $data['validate'] = true;

            return $this->template->load('template', 'auth/forgot_password', $data);
        }
    }
}