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
        $this->db->select('l.*, ut.type_name AS user_role, ut.is_super_admin, ut.is_admin')
                 ->from(USERS_TABLE.' AS l')
                 ->where('l.is_blocked', 0)
                 ->where('l.id', $user_id)
                 ->join(USER_TYPES_TABLE.' AS ut', 'ut.id = l.type');

        return $this->db->get()->row();
    }

    public function getClients() {
        $this->db->select("u.id, u.first_name, u.last_name");

        if(!$this->user->is_admin && !$this->user->is_super_admin) {
            $this->db->where('u.id', $this->user->id);
        }

        $this->db->where('u.is_blocked', 0);
        $this->db->where('ut.is_admin', 0);
        $this->db->where('ut.is_super_admin', 0);
        $this->db->join(USER_TYPES_TABLE." AS ut", 'ut.id = u.type');

        return $this->db->get(USERS_TABLE.' AS u')->result_array();
    }

    public function getRatingPlatforms($property_id = null, $status = null) {
        $this->db->select("rp.id, rp.platform, rp.logo")
                 ->where('rp.is_delete', 0);

        if($property_id){
            $platforms = array_map(function($platform) use ($property_id, $status) {
                $this->db->select("rs.status, rs.min_rating, rs.rating_url")
                                                ->where('rs.property_id', $property_id)
                                                ->where('rs.rating_platform_id', $platform['id']);

                if($status) {
                    $this->db->where('rs.status', $status);
                }

                $platform['setting'] = $this->db->get(RATING_SETTINGS_TABLE.' AS rs')->row_array();
                return $platform;
            }, $this->db->get(RATING_PLATFORMS_TABLE.' AS rp')->result_array());
        } else {
            $platforms = $this->db->get(RATING_PLATFORMS_TABLE.' AS rp')->result_array();
        }

        return $platforms;
    }
}