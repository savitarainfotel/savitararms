<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_types extends MY_Controller {
    public $redirect = 'user-types';
    private $table = USER_TYPES_TABLE;

	public function index() {
        checkAccess(USER_TYPES);

		$data['title'] = 'User types List';
		$data['pageTitle'] = 'User types';
        $data['datatables'] = true;
        $data['datatable'] = "$this->redirect/get";

        //!Breadcrumbs
        $this->breadcrumb->add('Home', site_url());
        $this->breadcrumb->add('User types', site_url($this->redirect));

		return $this->template->load('template', $this->redirect.'/list', $data);
	}

    public function get() {
        check_ajax();
        checkAccess(USER_TYPES);

        $this->load->model('User_types_model', 'data');

        $fetch_data = $this->data->make_datatables();
        $data = [];
        $sr = $this->input->post('start') + 1;

        $edit = user_privilege_register(USER_TYPES, 'edit');
        $delete = user_privilege_register(USER_TYPES, 'delete');
        $permissions = user_privilege_register(USER_TYPES, 'permissions');

        foreach($fetch_data as $record)
        {
            $sub_array = [];
            $sub_array[] = $sr;

            $sub_array[] = $record->is_super_admin ? "<b>$record->type_name</b>" : "<span>$record->type_name</span>";

            if($record->id > 1) {
                $action = get_link('edit', $edit, $this->redirect.'/edit/'.e_id($record->id));
                $action .= get_link('permissions', $permissions, $this->redirect.'/get-permissions-form/'.e_id($record->id));
                $action .= get_link('delete', $delete, $this->redirect.'/delete', ['id' => e_id($record->id)]);
    
                $sub_array[] = show_actions($action);
            } else {
                $sub_array[] = '';
            }

            /* if($edit) {
                $action .= '<a class="dropdown-item" href="'.site_url($this->redirect.'/edit/'.e_id($record->id)).'">
                                <i class="far fa-pencil-alt mr-2"></i> Edit
                            </a>';
            }

            if($permissions) {
                $action .= form_open($this->redirect.'/get-permissions-form/'.e_id($record->id), 'method="GET"');
                $action .= '<a class="dropdown-item btn-get-permissions" href="javascript:;">
                                <i class="far fa-user mr-2"></i> Permissions
                            </a>';
                $action .= form_close();
            }

            if($delete) {
                $action .= form_open($this->redirect.'/delete');
                $action .= form_hidden('id', e_id($record->id));
                $action .= '<a class="dropdown-item delete-archive-item" href="javascript:;">
                                <i class="far fa-trash-alt mr-2"></i> Delete
                            </a>';
                $action .= form_close();
            } */

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
        checkAccess(USER_TYPES, 'create');

		if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $this->load->model('user_types_model');
                $postArray = get_post_data();

                $id = $this->generalmodel->add($postArray, $this->table);

                if($id){
                    $this->generalmodel->update(['parent_id' => $id], ['parent_id' => 0], $this->table);
                    if(!empty($this->input->post('child_id')) && is_array($this->input->post('child_id'))) {
                        foreach ($this->input->post('child_id') as $child_id) {
                            $this->generalmodel->update(['id' => d_id($child_id)], ['parent_id' => $id], $this->table);
                        }
                    }
                    responseMsg(true, 'User Type has been created successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while creating User Type!');
                }
            }
        } else{
            $data['title'] = 'Create User Type';
            $data['pageTitle'] = 'User Types';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('User Types', site_url($this->redirect));
            $this->breadcrumb->add('Create', site_url($this->redirect));

            $data['userTypeList'] = $this->generalmodel->getAll($this->table, '*', ['is_delete' => 0, 'id >' => 2], 'id ASC');

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function edit(String $id) {
        checkAccess(USER_TYPES, 'edit');

        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_delete' => 0]);

		if($this->input->is_ajax_request()) {
            if(!$data['data']) {
                responseMsg(false, 'User Type not found!');
            }

            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $this->load->model('user_types_model');

                $postArray = get_post_data();

                $u_id = $this->generalmodel->update(['id' => $id], $postArray, $this->table);

                if($u_id){
                    $this->generalmodel->update(['parent_id' => $id], ['parent_id' => 0], $this->table);
                    if(!empty($this->input->post('child_id')) && is_array($this->input->post('child_id'))) {
                        foreach ($this->input->post('child_id') as $child_id) {
                            $this->generalmodel->update(['id' => d_id($child_id)], ['parent_id' => $id], $this->table);
                        }
                    }
                    responseMsg(true, 'User Type has been updated successfully!', $this->redirect.'/edit/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while updating User Type!');
                }
            }
        } else{
            if(!$data['data']) {
                flashMsg('User Type not found!', $this->redirect);
            }

            $data['title'] = 'Edit User Type';
            $data['pageTitle'] = 'User Types';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('User Types', site_url($this->redirect));
            $this->breadcrumb->add('Edit', site_url($this->redirect));

            $data['userTypeList'] = $this->generalmodel->getAll($this->table, '*', ['is_delete' => 0, 'id >' => 2], 'id ASC', '', [['key' => 'id', 'value' => [$id]]]);

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function delete(){
        checkAccess(USER_TYPES, 'delete');

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $id = d_id($this->input->post('id'));
            $getData = $this->generalmodel->get($this->table, 'id', ['id' => $id]);
            if(!empty($getData)){
                $updateArray = [
                    'is_delete' => 1
                ];

                $queryResult = $this->generalmodel->update(['id' => $id], $updateArray, $this->table);

                if($queryResult) {
                    responseMsg(true, 'User Type has been deleted successfully!');
                } else {
                    responseMsg(false, 'Something went wrong while deleting User Type!');
                }
            } else {
                responseMsg(false, 'User Type details not found!');
            }
        } else {
            responseMsg(false, 'Parameter missing!');
        }
    }

    public function get_permissions_form(String $u_type, String $u_team = '') {
        checkAccess(USER_TYPES, 'permissions');

		$data["accessList"] = $this->Permissions_model->getAccessList();
		$data["u_type"] = $u_type;
		$data["u_team"] = $u_team;

        responseMsg(true, null, null, null, $this->load->view($this->redirect.'/permissions-form', $data, true));
	}

    public function save_permissions() {
        checkAccess(USER_TYPES, 'permissions');
		$id = $this->Permissions_model->savePermissions();

        responseMsg($id, $id ? 'Permissions reset success.' : 'Permissions reset not success.');
	}

    private $validate = [
        [
            'field' => 'type_name',
            'label' => 'Name',
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 50 chars allowed for %s"
            ],
        ],
    ];
}