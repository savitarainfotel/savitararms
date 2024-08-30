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

		if(user_privilege_register(INVITES)) {
			$this->load->model('invites_model');
			$data['invites'] = $this->invites_model->count();
		}

		//!Breadcrumbs
		$this->breadcrumb->add('Home', site_url());
		$this->breadcrumb->add('Dashboard', site_url());
		
		return $this->template->load('template', 'dashboard', $data);
	}

	public function backup()
    {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '1024M');

		// Load the DB utility class
        $this->load->dbutil();
        $filename = url_title(APP_NAME, 'dash', TRUE).'-'.date('d-m-Y').'.sql';

        // Backup your entire database and assign it to a variable

        $prefs = [
            'tables'                => [],                          // Array of tables to backup.
            'ignore'                => [],                          // List of tables to omit from the backup
            'format'                => 'txt',                       // gzip, zip, txt
            'filename'              => $filename,                   // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'              => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'            => TRUE,                        // Whether to add INSERT data to backup file
            'newline'               => "\n",                        // Newline character used in backup file
            'foreign_key_checks'    => FALSE                        // Whether output should keep foreign key checks enabled.
        ];

        $backup = $this->dbutil->backup($prefs);

        // Load the file helper and store the file to the server
        $this->load->helper('file');

        $path = 'db-backups/';

        if(! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        write_file($path.$prefs['filename'], $backup);

		ini_restore('max_execution_time');
		ini_restore('memory_limit');

		flashMsg("DB bckup success.", 'dashboard');
    }
}