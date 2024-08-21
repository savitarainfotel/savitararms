<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions_model extends MY_Model {

    public function user_privilege_register($module, $action, $userType, $userTeamType=0)
    {
        $checkNav = [
			'n.is_deleted' => 0,
			'n.n_name'     => $module,
			'p.u_type'     => $userType,
			'p.u_team'     => $userTeamType
		];

        if($action) $checkNav['p.operation'] = $action;

        $this->db->select('p.id')
                 ->from(PERMISSIONS_TABLE.' p')
                 ->where($checkNav)
                 ->join(NAVBARS_TABLE.' n', 'n.id = p.nav_id');

        return $this->db->get()->row() ? true : false;
    }

    public function getAccessList()
    {
        $mainMenus = $this->db->select('id, s_name, parent_id')
                              ->from(SIDEBAR_TABLE)
                              ->where([ 'is_deleted' => 0, 'parent_id' => 0 ])
                              ->get()->result();

        $mainMenus = array_map(function($menu) {
            $submenu = $this->db->select('id, s_name, parent_id')
                                ->from(SIDEBAR_TABLE)
                                ->where([ 'is_deleted' => 0, 'parent_id' => $menu->id ])
                                ->get()->result();

            $menu->sub_menu = array_map(function($sub) {
                $sub->accessList = $this->db->select('n.id, n.n_title, n.operations, n.n_name')
                                            ->from(NAVBARS_TABLE.' n')
                                            ->where([ 'n.is_deleted' => 0, 'sidebar_id' => $sub->id, 'n.n_link != ' => '' ])
                                            ->get()->result();
                return $sub;
            }, $submenu);

            $menu->accessList = $this->db->select('n.id, n.n_title, n.operations, n.n_name')
                                        ->from(NAVBARS_TABLE.' n')
                                        ->where([ 'n.is_deleted' => 0, 'sidebar_id' => $menu->id, 'n.n_link != ' => '' ])
                                        ->get()->result();
            return $menu;
        }, $mainMenus);

        $accessList = $this->db->select('n.id, n.n_title, n.operations, n.n_name')
                               ->from(NAVBARS_TABLE.' n')
                               ->where([ 'n.is_deleted' => 0, 'sidebar_id' => 0, 'n.n_link != ' => '' ])
                               ->get()->result();

        return ['accessList' => $accessList, 'mainMenus' => $mainMenus];
    }

    public function savePermissions()
    {
        $u_type = d_id($this->input->post('u_type')) ?? 0;
        $u_team = d_id($this->input->post('u_team')) ?? 0;

        $this->db->trans_start();

        $this->db->delete(PERMISSIONS_TABLE, ['u_type' => $u_type, 'u_team' => $u_team]);

        if($this->input->post('permissions'))
        {
            foreach ($this->input->post('permissions') as $nav_id => $operations) {
                foreach ($operations as $operation) {
                    $data = [
                        'nav_id'        => $nav_id,
                        'operation'     => $operation,
                        'u_type'        => $u_type,
                        'u_team'        => $u_team
                    ];

                    $this->add($data, PERMISSIONS_TABLE);
                }
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}