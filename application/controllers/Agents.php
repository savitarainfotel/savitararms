<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends MY_Controller {
    public $redirect = AGENTS;
    private $table = USERS_TABLE;

	public function index() {
        checkAccess(AGENTS);

		$data['title'] = 'Agents List';
		$data['pageTitle'] = 'Agents';
        $data['datatables'] = true;
        $data['datatable'] = "$this->redirect/get";
        $data['is_agent'] = true;

        //!Breadcrumbs
        $this->breadcrumb->add('Home', site_url());
        $this->breadcrumb->add('Agents', site_url($this->redirect));

		return $this->template->load('template', USERS.'/list', $data);
	}

    public function get() {
        check_ajax();
        checkAccess(AGENTS);

        $this->load->model('Users_model', 'data');

        $fetch_data = $this->data->make_datatables();
        $data = [];
        $sr = $this->input->post('start') + 1;

        $edit = user_privilege_register(AGENTS, 'edit');
        $delete = user_privilege_register(AGENTS, 'delete');

        foreach($fetch_data as $record)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = anchor($this->redirect.'/edit/'.e_id($record->id), "$record->first_name $record->last_name", 'class="text-primary text-decoration"');
            $sub_array[] = $record->email;
            $sub_array[] = $record->mobile;

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
        checkAccess(AGENTS, 'create');

		if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();

                $id = $this->generalmodel->add($postArray, $this->table);

                if($id){
                    responseMsg(true, 'Agent has been created successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while creating Agent!');
                }
            }
        } else{
            $data['title'] = 'Create Agent';
            $data['pageTitle'] = 'Agents';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Agents', site_url($this->redirect));
            $this->breadcrumb->add('Create', site_url($this->redirect));

            $where = [
                'is_delete'      => 0,
                'is_admin'       => 0,
                'is_super_admin' => 0,
                'is_agent'       => 1
            ];

            $data['userTypeList'] = $this->generalmodel->getAll(USER_TYPES_TABLE, 'id, type_name', $where, 'id ASC');

            return $this->template->load('template', USERS.'/create', $data);
        }
	}

    public function edit(String $id) {
        checkAccess(AGENTS, 'edit');

        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_blocked' => 0]);

		if($this->input->is_ajax_request()) {
            if(!$data['data']) {
                responseMsg(false, 'Agent not found!');
            }

            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();

                $u_id = $this->generalmodel->update(['id' => $id], $postArray, $this->table);

                if($u_id){
                    responseMsg(true, 'Agent has been updated successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while updating Agent!');
                }
            }
        } else{
            if(!$data['data']) {
                flashMsg('Agent not found!', $this->redirect);
            }

            $data['title'] = 'Edit Agent';
            $data['pageTitle'] = 'Agents';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Agents', site_url($this->redirect));
            $this->breadcrumb->add('Edit', site_url($this->redirect));

            $where = [
                'is_delete'      => 0,
                'is_admin'       => 0,
                'is_super_admin' => 0,
                'is_agent'       => 1
            ];

            $data['userTypeList'] = $this->generalmodel->getAll(USER_TYPES_TABLE, 'id, type_name', $where, 'id ASC');

            return $this->template->load('template', USERS.'/create', $data);
        }
	}

    public function delete(){
        checkAccess(AGENTS, 'delete');

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $id = d_id($this->input->post('id'));
            $getData = $this->generalmodel->get($this->table, 'id', ['id' => $id]);
            if(!empty($getData)){
                $updateArray = [
                    'is_blocked' => 1
                ];

                $queryResult = $this->generalmodel->update(['id' => $id], $updateArray, $this->table);

                if($queryResult) {
                    responseMsg(true, 'Agent has been deleted successfully!');
                } else {
                    responseMsg(false, 'Something went wrong while deleting Agent!');
                }
            } else {
                responseMsg(false, 'Agent details not found!');
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