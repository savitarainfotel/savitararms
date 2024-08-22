<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function index() {
		$data['title'] = 'Dashboard';
		$data['pageTitle'] = 'Dashboard';

		if(user_privilege_register(CLIENTS)) {
			$this->load->model('users_model');
			$data['clients'] = $this->users_model->count();
		}

		if(user_privilege_register(PROPERTIES)) {
			$this->load->model('properties_model');
			$data['properties'] = $this->properties_model->count();
		}

		//!Breadcrumbs
		$this->breadcrumb->add('Home', site_url());
		$this->breadcrumb->add('Dashboard', site_url());
		
		return $this->template->load('template', 'dashboard', $data);
	}
}