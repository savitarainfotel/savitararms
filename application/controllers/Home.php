<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Home';

		return $this->template->load('front-end/template', 'front-end/home', $data);
	}

	public function error_404()
	{
		$data['title'] = 'Error 404';

		return $this->template->load('front-end/template', 'front-end/error_404', $data);
	}
	public function book_now()
	{
		if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();
				$this->load->model('generalmodel');
                
                $id = $this->generalmodel->add($postArray, CONTACT_US_TABLE);

                if($id){
                    responseMsg(true, 'Inquiry has been created successfully!', true);
                } else {
                    responseMsg(false, 'Something went wrong while creating Inquiry!');
                }
            }
        } else{
			$data['title'] = 'Book Now';
			$data['validate'] = true;

			return $this->template->load('front-end/template', 'front-end/book_now', $data);
		}
	}

	public function logout()
	{
		$this->session->unset_userdata(array_keys($this->session->userdata()));
        flashMsg("You have successfully logged out!", 'auth/login');
	}

	protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 250 chars allowed for %s"
            ],
        ],
        [
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'required|numeric|callback_validate_mobile',
            'errors' => [
                'required' => "%s is required",
                'numeric' => "%s is invalid",
                'exact_length' => "%s is invalid",
            ],
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|max_length[100]|valid_email',
            'errors' => [
                'required' => "%s is required",
                'valid_email' => "%s is invalid",
                'max_length' => "Max 100 chars allowed"
            ],
        ],
        [
            'field' => 'country',
            'label' => 'Country',
            'rules' => 'required|in_list[United States,Australia,Canada,France]',
            'errors' => [
                'required' => "%s is required",
                'in_list' => "Invalid %s selected"
            ],
        ],
        [
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'required|max_length[1000]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 1000 chars allowed for %s"
            ],
        ],
    ];

    public function validate_mobile($mobile)
    {
        if (empty($mobile)) {
            return true;
        }

        if (preg_match('/^\+?[1-9]\d{9,14}$/', $mobile)) {
            return true;
        }else {
            $this->form_validation->set_message('validate_mobile', "%s is invalid!");
            return false;
        }
    }
}