<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function index() {
		$data['title'] = 'Dashboard';
		$data['pageTitle'] = 'Dashboard';

		$data['clients'] = $this->generalmodel->check(USERS_TABLE, ['type >' => 2], 'COUNT(id)');

		//!Breadcrumbs
		$this->breadcrumb->add('Home', site_url());
		$this->breadcrumb->add('Dashboard', site_url());

		return $this->template->load('template', 'dashboard', $data);
	}
}