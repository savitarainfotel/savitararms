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
		$data['title'] = 'Book Now';

		return $this->template->load('front-end/template', 'front-end/book_now', $data);
	}

	public function logout()
	{
		$this->session->unset_userdata(array_keys($this->session->userdata()));
        flashMsg("You have successfully logged out!", 'auth/login');
	}
}