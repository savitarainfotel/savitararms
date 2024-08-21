<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function index() {
		$data['title'] = 'Dashboard';
		$data['pageTitle'] = 'Dashboard';

		$this->load->model('users_model');
		$data['clients'] = $this->users_model->count();

		//!Breadcrumbs
		$this->breadcrumb->add('Home', site_url());
		$this->breadcrumb->add('Dashboard', site_url());
		
		return $this->template->load('template', 'dashboard', $data);
	}
}