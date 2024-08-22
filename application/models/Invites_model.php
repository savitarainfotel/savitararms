<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invites_model extends MY_Model {
    public $table = INVITES_TABLE." AS i";
	public $select_column = ['i.id', 'c.first_name', 'c.last_name', 'i.name', 'i.created_at', 'i.client_id'];
	public $search_column = ['c.first_name', 'c.last_name', 'i.name', 'i.created_at'];
    public $order_column = [null, 'i.name', 'c.first_name', 'i.created_at', null];

	public $order = ['i.id' => 'DESC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'i.id')
				 ->from($this->table)
				 ->where('i.is_delete', 0)
                 ->join(USERS_TABLE.' AS c', 'c.id = i.client_id');

		if(!$this->user->is_admin && !$this->user->is_super_admin) {
			$this->db->where('c.id', $this->user->id);
		}

		if($count === false) $this->datatable();
	}
}