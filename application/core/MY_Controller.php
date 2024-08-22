<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class MY_Controller extends CI_Controller
{
    public $path = 'uploads/';
    public $user = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('generalmodel');

        $currentController = strtolower($this->router->fetch_class());

        if(in_array($currentController, ['login', 'forgot_password'])) {
            if ($this->session->auth) return redirect('dashboard');
        } else {
            if (!$this->session->auth) return redirect('auth/login');
            $this->user = $this->generalmodel->getUserProfile(d_id($this->session->auth));

            if(empty($this->user)) {
                $this->session->unset_userdata(array_keys($this->session->userdata()));
                flashMsg('You have been logged out!', 'auth/login');
            }
        }
	}

	protected function uploadImage($upload, $exts='jpg|jpeg|png', $size=[], $name=null)
    {
        create_directories($this->path);

        $this->load->library('upload');

        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => $exts,
                'file_name'        => $name ? $name : time(),
                'file_ext_tolower' => TRUE,
                'max_size'         => 15360,
                'overwrite'        => FALSE
            ];

        $config = array_merge($config, $size);

        $this->upload->initialize($config);

        if ($this->upload->do_upload($upload))
            return ['error' => false, 'message' => $this->upload->data("file_name")];
        else
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
    }

    protected function uploadMultipleFiles($files, $name)
    {
        $images = [];
        $uploadError = false;

        foreach ($files[$name]['name'] as $key => $image) {
            $_FILES['image']['name']= cleanInput($files[$name]['name'][$key]);
            $_FILES['image']['type']= $files[$name]['type'][$key];
            $_FILES['image']['tmp_name']= $files[$name]['tmp_name'][$key];
            $_FILES['image']['error']= $files[$name]['error'][$key];
            $_FILES['image']['size']= $files[$name]['size'][$key];

            $filename = cleanInput($files[$name]['name'][$key]);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = url_title(rtrim($filename, ".$ext"), '-', TRUE).'-'.date('m-d-Y-H-i-s').'-'.uniqid().'.'.$ext;

            $img = $this->uploadImage('image', 'pdf|xls|xlsx|doc|docx|csv|jpeg|jpg|png|gif', [], $filename);

            if($img['error']) {
                $uploadError = $img['message'];
                break;
            }

            $images[] = ! $img['error'] ? $img['message'] : '';
        }

        return ['error' => $uploadError, 'images' => $images];
    }

	public function error_404()
	{
		$data['title'] = 'Error 404';
        $data['errorPage'] = true;

		return $this->template->load('template', 'error_404', $data);
	}

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

    public function validate_password($password)
    {
        if (empty($password)) {
            return true;
        }

        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/';

        if (preg_match($regex, $password)) {
            return true;
        }else {
            $this->form_validation->set_message('validate_password', "At least 8 characters, one uppercase, one lowercase, one number, and one special character!");
            return false;
        }
    }
}