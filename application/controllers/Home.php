<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function index()
	{
		return redirect('dashboard');
	}

	public function logout()
	{
		$this->session->unset_userdata(array_keys($this->session->userdata()));
        flashMsg("You have successfully logged out!", 'auth/login');
	}
}