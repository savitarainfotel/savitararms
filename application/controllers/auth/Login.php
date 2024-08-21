<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Login extends MY_Controller
{
    protected $table = USERS_TABLE;

	public function index()
	{
        if($this->input->is_ajax_request()) {
            $login = [
                [
                    'field' => 'email',
                    'label' => 'Email address',
                    'rules' => 'required|max_length[100]'.($this->input->cookie('dev') ? '' : '|valid_email'),
                    'errors' => [
                        'required' => "%s is required",
                        'max_length' => "Max 100 chars allowed for %s",
                        'valid_email' => "Please enter a valid %s.",
                    ],
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "%s is required"
                    ],
                ]
            ];
            $this->form_validation->set_rules($login);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $response = $this->generalmodel->login($this->table);
                responseMsg($response['status'], $response['message'], !empty($response['redirect']) ? $response['redirect'] : '');
            }
        } else{
            if($this->input->get('dev')){
                $this->load->helper('cookie');
                $cookie = [
                    'name'   => 'dev',
                    'value'  => $this->input->get('dev'),
                    'expire' => '0',
                    'secure' => TRUE,
                    'httponly' => TRUE
                ];

                $this->input->set_cookie($cookie);
            }

            if($this->input->get('login')){
                $this->load->helper('cookie');
                $cookie = [
                    'name'   => 'go-go-login',
                    'value'  => $this->input->get('login'),
                    'expire' => '0',
                    'secure' => TRUE,
                    'httponly' => TRUE
                ];

                $this->input->set_cookie($cookie);
            }

            $data['title'] = 'Sign In';
            $data['authPage'] = true;
            $data['validate'] = true;
            
            return $this->template->load('template', 'auth/login', $data);
        }
	}

    public function change_password()
    {
        $token = d_id($this->uri->segment(2));

        $post = [
            'id'   	        => $token,
            'updated_at >= ' => date('Y-m-d H:i:s'),
            'is_blocked'    => 0
        ];

        $user = $this->generalmodel->get($this->table, 'id, pass_token, pass_salt', $post);

        if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[50]',
                ['required' => "%s is required", 'max_length' => "Max 50 chars allowed"
            ]);

            /* $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[50]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>])(?=.*[^\w\d\s]).{8,}$/]', [
				'required'      => 'You must provide a %s.',
				'min_length'    => '%s must be at least 8 characters in length.',
				'max_length'    => '%s cannot exceed 50 characters in length.',
				'regex_match'   => '%s must contain at least one uppercase letter, one lowercase letter, one number, one special character, and no spaces.'
			]); */

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                if(!password_verify(e_id($token) . $user['pass_salt'], $user['pass_token'])) {
                    responseMsg(false, "Token has been expired.", 'auth/login');
                }

                $hp = encr_password($this->input->post('password'));

                $update = [
                    'password_salt' => $hp['salt'],
                    'password'      => $hp['hashedPassword']
                ];

                if ($this->generalmodel->update(['id' => $token], $update, $this->table)) {
                    responseMsg(true, 'Password changed. Login with new password.', 'auth/login');
                } else {
                    responseMsg(false, 'Password not changed. Try again.');
                }
            }
        } else{
            if(password_verify(e_id($token) . $user['pass_salt'], $user['pass_token'])) {
                $data['title'] = 'Change password';
                $data['validate'] = true;
                
                return $this->template->load('template', 'auth/change_password', $data);
            }else {
                flashMsg("Token has been expired.", 'auth/login');
            }
        }
    }
}