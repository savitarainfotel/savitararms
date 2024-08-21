<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    public $redirect = CLIENTS;
    private $table = USERS_TABLE;

	public function index() {
        checkAccess(CLIENTS);

		$data['title'] = 'Clients List';
		$data['pageTitle'] = 'Clients';
        $data['datatables'] = true;
        $data['datatable'] = "$this->redirect/get";

        //!Breadcrumbs
        $this->breadcrumb->add('Home', site_url());
        $this->breadcrumb->add('Clients', site_url($this->redirect));

		return $this->template->load('template', $this->redirect.'/list', $data);
	}

    public function get() {
        check_ajax();
        checkAccess(CLIENTS);

        $this->load->model('Users_model', 'data');

        $fetch_data = $this->data->make_datatables();
        $data = [];
        $sr = $this->input->post('start') + 1;

        $edit = user_privilege_register(CLIENTS, 'edit');
        $delete = user_privilege_register(CLIENTS, 'delete');

        foreach($fetch_data as $record)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = anchor($this->redirect.'/edit/'.e_id($record->id), "$record->first_name $record->last_name", 'class="text-primary text-decoration"');
            $sub_array[] = $record->email;
            $sub_array[] = $record->mobile;
            $sub_array[] = $record->type_name;

            $action = get_link('edit', $edit, $this->redirect.'/edit/'.e_id($record->id));
            $action .= get_link('delete', $delete, $this->redirect.'/delete', ['id' => e_id($record->id)]);

            $sub_array[] = show_actions($action);

            $data[] = $sub_array;
            $sr++;
        }

        $output = [
            "draw"              => intval($this->input->post('draw')),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];

        die(json_encode($output));
    }

    public function create() {
        checkAccess(CLIENTS, 'create');

		if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();

                $id = $this->generalmodel->add($postArray, $this->table);

                if($id){
                    responseMsg(true, 'Client has been created successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while creating Client!');
                }
            }
        } else{
            $data['title'] = 'Create Client';
            $data['pageTitle'] = 'Clients';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Clients', site_url($this->redirect));
            $this->breadcrumb->add('Create', site_url($this->redirect));

            $data['userTypeList'] = $this->generalmodel->getAll(USER_TYPES_TABLE, 'id, type_name', ['is_delete' => 0], 'id ASC');

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function edit(String $id) {
        checkAccess(CLIENTS, 'edit');

        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_blocked' => 0]);

		if($this->input->is_ajax_request()) {
            if(!$data['data']) {
                responseMsg(false, 'Client not found!');
            }

            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();

                $u_id = $this->generalmodel->update(['id' => $id], $postArray, $this->table);

                if($u_id){
                    responseMsg(true, 'Client has been updated successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while updating Client!');
                }
            }
        } else{
            if(!$data['data']) {
                flashMsg('Client not found!', $this->redirect);
            }

            $data['title'] = 'Edit Client';
            $data['pageTitle'] = 'Clients';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Clients', site_url($this->redirect));
            $this->breadcrumb->add('Edit', site_url($this->redirect));

            $data['userTypeList'] = $this->generalmodel->getAll(USER_TYPES_TABLE, 'id, type_name', ['is_delete' => 0], 'id ASC');

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function delete(){
        checkAccess(CLIENTS, 'delete');

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $id = d_id($this->input->post('id'));
            $getData = $this->generalmodel->get($this->table, 'id', ['id' => $id]);
            if(!empty($getData)){
                $updateArray = [
                    'is_blocked' => 1
                ];

                $queryResult = $this->generalmodel->update(['id' => $id], $updateArray, $this->table);

                if($queryResult) {
                    responseMsg(true, 'Client has been deleted successfully!');
                } else {
                    responseMsg(false, 'Something went wrong while deleting Client!');
                }
            } else {
                responseMsg(false, 'Client details not found!');
            }
        } else {
            responseMsg(false, 'Parameter missing!');
        }
    }

    
    public function verify_mobile(){
        $user = $this->generalmodel->get($this->table, 'id', ['id <> ' => d_id($this->input->get('existing') ?? 0), 'mobile' => $this->input->get('item')]);

        if ($user) {
            responseMsg(false, ['mobile' => "The Mobile is already in use"], null, true);
        } else {
            responseMsg(true, '');
        }
    }

    
    public function verify_email(){
        $user = $this->generalmodel->get($this->table, 'id', ['id <> ' => d_id($this->input->get('existing') ?? 0), 'email' => $this->input->get('item')]);
        if ($user) {
            responseMsg(false, ['email' => "The Email is already in use"], null, true);
        } else {
            responseMsg(true, '');
        }
    }

    public function mobile_check($str)
    {   
        $where = ['mobile' => $str, 'id != ' => $this->uri->segment(3) ? d_id($this->uri->segment(3)) : 0];
        
        if ($this->generalmodel->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $where = ['email' => $str, 'id != ' => $this->uri->segment(3) ? d_id($this->uri->segment(3)) : 0];
        
        if ($this->generalmodel->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function password_check($str)
    {        
        if ($this->uri->segment(2) === 'create' && empty($str)) {
            $this->form_validation->set_message('password_check', '%s is required');
            return FALSE;
        } else
            return TRUE;
    }

    private $validate = [
        [
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 20 chars allowed for %s"
            ],
        ],
        [
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 20 chars allowed for %s"
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'required|numeric|callback_validate_mobile|callback_mobile_check',
            'errors' => [
                'required' => "%s is required",
                'numeric' => "%s is invalid",
                'exact_length' => "%s is invalid",
            ],
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|max_length[100]|valid_email|callback_email_check',
            'errors' => [
                'required' => "%s is required",
                'valid_email' => "%s is invalid",
                'max_length' => "Max 100 chars allowed"
            ],
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'max_length[50]|callback_password_check|callback_validate_password',
            'errors' => [
                'max_length' => "Max 50 chars allowed"
            ],
        ],
        [
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'matches[password]',
            'errors' => [
                'matches' => "Password & %s must be same"
            ],
        ]
    ];
}