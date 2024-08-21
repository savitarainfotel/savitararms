<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model {

    public $table = USERS_TABLE." AS u";
	public $select_column = ['u.id', 'u.first_name', 'u.last_name', 'u.email', 'u.mobile', 'ut.type_name'];
	public $search_column = ['u.id', 'u.first_name', 'u.last_name', 'u.email', 'u.mobile', 'ut.type_name'];
    public $order_column = [null, 'u.first_name', 'u.email', 'u.mobile', 'ut.type_name', null];

	public $order = ['u.id' => 'ASC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'u.id')
				 ->from($this->table)
				 ->where(['ut.is_admin' => $this->input->post('is_admin') ?? 0])
				 ->where(['u.is_blocked' => 0, 'ut.is_delete' => 0, 'ut.is_super_admin' => 0])
				 ->join(USER_TYPES_TABLE." AS ut", 'ut.id = u.type');

		if(!$this->user->is_admin && !$this->user->is_super_admin) {
			$this->db->where('u.id', $this->user->id);
		}

		if($count === false) $this->datatable();
	}
}