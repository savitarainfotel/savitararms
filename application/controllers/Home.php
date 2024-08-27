<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$data['title'] = 'Home';

		return $this->template->load('front-end/template', 'front-end/home', $data);
	}

	public function logout()
	{
		$this->session->unset_userdata(array_keys($this->session->userdata()));
        flashMsg("You have successfully logged out!", 'auth/login');
	}
}