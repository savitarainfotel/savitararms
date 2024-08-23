<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invites extends MY_Controller {

    public $redirect = INVITES;
    private $table = INVITES_TABLE;
    public $clientList = [];

	public function __construct() {
        parent::__construct();
        $this->clientList = $this->generalmodel->getClients();
    }

	public function index() {
        checkAccess(INVITES);
		$data['title'] = 'Invite List';
		$data['pageTitle'] = 'Invites';
        $data['datatables'] = true;
        $data['status'] = 1;
        $data['datatable'] = "$this->redirect/get";

        //!Breadcrumbs
        $this->breadcrumb->add('Home', site_url());
        $this->breadcrumb->add('Invites', site_url($this->redirect));

		return $this->template->load('template', $this->redirect.'/list', $data);
	}

    public function get()
    {
        check_ajax();
        checkAccess(INVITES);

        $this->load->model('Invites_model', 'data');

        $fetch_data = $this->data->make_datatables();
        $data = [];
        $sr = $this->input->post('start') + 1;
        $edit = user_privilege_register(INVITES, 'edit');
        $delete = user_privilege_register(INVITES, 'delete');

        foreach($fetch_data as $k => $record)
        {
            $sub_array = [];
            $sub_array[] = $sr++;

            $sub_array[] = anchor($this->redirect.'/view/'.e_id($record->id), $record->name, 'class="text-primary text-decoration"');

            if($this->user->is_admin || $this->user->is_super_admin) {
                $sub_array[] = anchor('users/edit/'.e_id($record->client_id), "$record->first_name $record->last_name", 'class="text-primary text-decoration"');
            }

            $sub_array[] = date('d-m-Y', strtotime($record->created_at));

            $action = get_link('edit', $edit, $this->redirect.'/edit/'.e_id($record->id));
            $action .= get_link('delete', $delete, $this->redirect.'/delete', ['id' => e_id($record->id)]);
            
            $sub_array[] = show_actions($action);

            $data[] = $sub_array;
        }

        $output = [
            "draw"              => intval($this->input->post('draw')),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];

        die(json_encode($output));
    }

    public function view(String $id) {
        checkAccess(INVITES);
        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_delete' => 0]);

        if(!$data['data']) {
            flashMsg('Invite not found!', $this->redirect);
        }

        $data['title'] = 'View Invite';
        $data['pageTitle'] = 'Invites';
        $data['validate'] = true;
        $data['properties'] = $this->generalmodel->getProperties($data['data']['client_id']);
        $data['datatables'] = true;
        $data['datatable'] = "$this->redirect/get-invites";

        //!Breadcrumbs
        $this->breadcrumb->add('Home', site_url());
        $this->breadcrumb->add('Invites', site_url($this->redirect));
        $this->breadcrumb->add($data['data']['name'], site_url($this->redirect.'/view/'.e_id($data['data']['id'])));
        $this->breadcrumb->add('View', site_url($this->redirect));

        return $this->template->load('template', $this->redirect.'/view', $data);
	}

    public function create() {
        checkAccess(INVITES, 'create');
		if($this->input->is_ajax_request()) {
            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();
                $this->load->model('invites_model');
                
                $id = $this->invites_model->add($postArray, $this->table);

                if($id){
                    responseMsg(true, 'Invite has been created successfully!', $this->redirect.'/view/'.e_id($id));
                } else {
                    responseMsg(false, 'Something went wrong while creating Invite!');
                }
            }
        } else{
            $data['title'] = 'Create Invite';
            $data['pageTitle'] = 'Invites';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Invites', site_url($this->redirect));
            $this->breadcrumb->add('Create', site_url($this->redirect.'/create'));

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function edit(String $id) {
        checkAccess(INVITES, 'edit');
        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_delete' => 0]);

		if($this->input->is_ajax_request()) {
            if(!$data['data']) {
                responseMsg(false, 'Invite not found!');
            }

            $this->form_validation->set_rules($this->validate);

            if ($this->form_validation->run() == FALSE) {
                responseMsg(false, $this->form_validation->error_array(), null, true);
            } else {
                $postArray = get_post_data();

                $u_id = $this->generalmodel->update(['id' => $id], $postArray, $this->table);

                if($u_id){
                    responseMsg(true, 'Invite has been updated successfully!', true);
                } else {
                    responseMsg(false, 'Something went wrong while updating Invite!');
                }
            }
        } else{
            if(!$data['data']) {
                flashMsg('Invite not found!', $this->redirect);
            }

            $data['title'] = 'Edit Invite';
            $data['pageTitle'] = 'Invites';
            $data['validate'] = true;

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Invites', site_url($this->redirect));
            $this->breadcrumb->add($data['data']['name'], site_url($this->redirect.'/view/'.e_id($data['data']['id'])));
            $this->breadcrumb->add('Edit', site_url($this->redirect));

            return $this->template->load('template', $this->redirect.'/create', $data);
        }
	}

    public function rating_settings(String $id) {
        checkAccess(INVITES, 'rating_settings');

        $id = d_id($id);
        $data['data'] = $this->generalmodel->get($this->table, '*', ['id' => $id, 'is_delete' => 0]);

		if($this->input->is_ajax_request()) {
            if(!$data['data']) {
                responseMsg(false, 'Invite not found!');
            }

            $postArray = get_post_data();

            if(!empty($postArray['settings'])) {
                foreach($postArray['settings'] as $rating_platform_id => $setting) {
                    $where = $settingsArray = [
                        'property_id' => $id,
                    	'rating_platform_id' => d_id($rating_platform_id)
                    ];

                    $property_id = $this->generalmodel->get(RATING_SETTINGS_TABLE, 'property_id', $settingsArray);

                    $settingsArray['status'] = !empty($setting['status']) ? $setting['status'] : 0;
                    $settingsArray['min_rating'] = $setting['min_rating'];
                    $settingsArray['rating_url'] = $setting['rating_url'];

                    if($property_id) {
                        $u_id = $this->generalmodel->update($where, $settingsArray, RATING_SETTINGS_TABLE);
                    } else {
                        $u_id = $this->generalmodel->add($settingsArray, RATING_SETTINGS_TABLE);
                    }
                }

                if(!empty($u_id)){
                    responseMsg(true, 'Rating settings has been updated successfully!', true);
                } else {
                    responseMsg(false, 'Something went wrong while updating rating settings!');
                }
            } else {
                responseMsg(false, 'Params are missing!');
            }

        } else{
            if(!$data['data']) {
                flashMsg('Invite not found!', $this->redirect);
            }

            $data['title'] = 'Rating settings';
            $data['pageTitle'] = 'Invites';
            $data['validate'] = true;
            $data['rating_platforms'] = $this->generalmodel->getRatingPlatforms($id);

            //!Breadcrumbs
            $this->breadcrumb->add('Home', site_url());
            $this->breadcrumb->add('Invites', site_url($this->redirect));
            $this->breadcrumb->add($data['data']['name'], site_url($this->redirect.'/view/'.e_id($data['data']['id'])));
            $this->breadcrumb->add('Rating settings', site_url($this->redirect));

            return $this->template->load('template', $this->redirect.'/rating_settings', $data);
        }
	}

    public function delete(){
        checkAccess(INVITES, 'delete');

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $id = d_id($this->input->post('id'));
            $getData = $this->generalmodel->get($this->table, 'id', ['id' => $id]);
            if(!empty($getData)){
                $updateArray = [
                    'is_delete' => 1
                ];

                $queryResult = $this->generalmodel->update(['id' => $id], $updateArray, $this->table);

                if($queryResult) {
                    responseMsg(true, 'Invite has been deleted successfully!');
                } else {
                    responseMsg(false, 'Something went wrong while deleting property!');
                }
            } else {
                responseMsg(false, 'Invite details not found!');
            }
        } else {
            responseMsg(false, 'Parameter missing!');
        }
    }

    public function send_invites(){
        checkAccess(INVITES, 'send_invites');

        if(!empty($this->input->post()) && $this->input->is_ajax_request()){
            $id = d_id($this->input->post('invite_id'));
            $inviteData = $this->generalmodel->get($this->table, 'id, email, name', ['id' => $id]);
            if(!empty($inviteData)){
                $postArray = get_post_data();

                if(!empty($postArray['property_ids']) && is_array($postArray['property_ids'])) {
                    $this->load->model('sent_invites_model');

                    $id = $this->sent_invites_model->send_invites($postArray, $inviteData);
    
                    if($id){
                        responseMsg(true, 'Invites has been created successfully!', true);
                    } else {
                        responseMsg(false, 'Something went wrong while creating invites!');
                    }   
                } else {
                    responseMsg(false, 'Properties are missing while creating invite!');
                }
            } else {
                responseMsg(false, 'Invite details not found!');
            }
        } else {
            responseMsg(false, 'Parameter missing!');
        }
    }

    public function get_invites()
    {
        check_ajax();
        checkAccess(INVITES, 'send_invites');

        $this->load->model('sent_invites_model', 'data');

        $fetch_data = $this->data->make_datatables();
        $data = [];
        $sr = $this->input->post('start') + 1;

        foreach($fetch_data as $k => $record)
        {
            $sub_array = [];
            $sub_array[] = $sr++;

            $sub_array[] =  form_open($this->redirect.'/view-sent-invite/'.e_id($record->id), 'method="GET"').
                                    '<a class="bs-tooltips text-primary text-decoration btn-modal-item" data-modal-title="Rating given" data-bs-toggle="tooltip" data-bs-placement="top" data-original-title="View Rating given" aria-label="View Rating given" data-bs-original-title="View Rating given" href="javascript:;">
                                        '.$record->property_name.'
                                    </a>'.
                            form_close();
            $sub_array[] = status($record->status);
            $sub_array[] = date('d-m-Y', strtotime($record->created_at));

            $data[] = $sub_array;
        }

        $output = [
            "draw"              => intval($this->input->post('draw')),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];

        die(json_encode($output));
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|max_length[250]',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 250 chars allowed for %s"
            ],
        ],
        [
            'field' => 'client_id',
            'label' => 'Client',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is required"
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'numeric|callback_validate_mobile',
            'errors' => [
                'numeric' => "%s is invalid",
                'exact_length' => "%s is invalid",
            ],
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|max_length[100]|valid_email',
            'errors' => [
                'required' => "%s is required",
                'valid_email' => "%s is invalid",
                'max_length' => "Max 100 chars allowed"
            ],
        ]
    ];
}