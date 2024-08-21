<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Generalmodel extends MY_Model
{
    public function login($table){
        $this->db->select('id, password_salt, password')->from($table)
                 ->where('is_blocked', 0)
                 ->where('email', $this->input->post('email'));

        $user = $this->db->get()->row();

        if($user) {
            $dev = false;

            if($this->input->cookie('dev')) {
                $dev = $this->db->get_where(LOGIN_TOKENS_TABLE, ['login_token' => $this->input->cookie('dev')])->row_array();
            }

            if($dev || password_verify($this->input->post('password') . $user->password_salt, $user->password)) {
                // Store last login and ip address
                $update = [
                    'lastlogin_at' => time(),
                    'ip_address'   => $this->input->ip_address()
                ];
                $this->update(['id' => $user->id], $update, $table);
                $this->session->set_userdata('auth', e_id($user->id));

                return ['status' => false, 'message' => "You have successfully logged in!", 'redirect' => 'dashboard'];
            } else
                return ['status' => true, 'message' => "Password is invalid"];
        } else {
            return ['status' => true, 'message' => "Email not registered or account blocked."];
        }

        return $user;
    }

    public function getUserProfile($user_id){
        $this->db->select('l.*, ut.type_name AS user_role, ut.is_super_admin')
                 ->from(USERS_TABLE.' AS l')
                 ->where('l.is_blocked', 0)
                 ->where('l.id', $user_id)
                 ->join(USER_TYPES_TABLE.' AS ut', 'ut.id = l.type');

        return $this->db->get()->row();
    }

    public function userTypeList($where = '') {
        $this->db->select('ut.id, ut.type_name')
                 ->from(USER_TYPES_TABLE.' AS ut')
                 ->where(['ut.is_delete' => 0])
                 ->order_by('ut.id ASC');

        return $this->db->get()->result();
    }

    public function getAssigneeUsers($assignees){
        if(!empty($assignees)){
            $this->db->select('u.id, CONCAT(u.first_name, CASE WHEN u.last_name IS NULL THEN "" ELSE CONCAT( " ", u.last_name, "" ) END) as assignee')
                     ->where(['u.is_blocked' => 0])
                     ->where_in('u.id', explode(',', $assignees));

            return $this->db->get('users AS u')->result_array();
        } else 
            return [];
    }

    public function nationalityList() {
        $this->db->select('*')
                 ->from(NATIONALITY_TABLE)
                 ->order_by('name ASC');

        return $this->db->get()->result();
    }

    public function getUsers() {
        $this->db->select("u.id, u.first_name, u.last_name");
        if(!$this->user->is_super_admin) {
            $this->db->where('u.id', $this->user->id);
        }

        $this->db->where('u.is_blocked', 0);
        $this->db->where('ut.is_super_admin', 0);
        $this->db->join(USER_TYPES_TABLE." AS ut", 'ut.id = u.type');

        return $this->db->get('users AS u')->result();
    }

    public function departureList() {
        $this->db->select('*')
                 ->from(DESTINATION_PLACES_TABLE)
                 ->where('is_deleted', 0)
                 ->order_by('name ASC');

        return $this->db->get()->result();
    }
}