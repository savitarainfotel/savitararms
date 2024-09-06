<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Properties_model extends MY_Model {
    public $table = PROPERTIES_TABLE." AS p";
	public $select_column = ['p.id', 'c.first_name', 'c.last_name', 'p.name', 'p.hosted_on', 'p.created_at', 'p.client_id'];
	public $search_column = ['c.first_name', 'c.last_name', 'p.name', 'p.hosted_on', 'p.created_at'];
    public $order_column = [null, 'p.name', 'p.hosted_on', 'c.first_name', 'p.created_at', null];

	public $order = ['p.id' => 'DESC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'p.id')
				 ->from($this->table)
				 ->where('p.is_delete', 0)
                 ->join(USERS_TABLE.' AS c', 'c.id = p.client_id');

		if(!$this->user->is_admin && !$this->user->is_super_admin && !$this->user->is_agent) {
			$this->db->where('c.id', $this->user->id);
		}

		if($this->user->is_agent) {
            $this->db->where('c.assigned_to', $this->user->id);
        }

		if($count === false) $this->datatable();
	}
}