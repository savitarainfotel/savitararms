<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sent_invites_model extends MY_Model {
    public $table = SEND_INVITES_TABLE." AS i";
	public $select_column = ['i.id', 'CONCAT(p.name, " - ", hosted_on) AS property_name', 'i.status', 'i.created_at'];
	public $search_column = ['p.name', 'i.status', 'i.created_at'];
    public $order_column = [null, 'p.name', 'i.status', 'i.created_at', null];

	public $order = ['i.id' => 'DESC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'i.id')
				 ->from($this->table)
				 ->where('i.is_delete', 0)
                 ->join(PROPERTIES_TABLE.' AS p', 'p.id = i.property_id');

		if(!$this->user->is_admin && !$this->user->is_super_admin) {
			$this->db->where('p.client_id', $this->user->id);
		}

		if($this->input->post('invite_id')) {
			$this->db->where('i.invite_id', d_id($this->input->post('invite_id')));
		}

		if($count === false) $this->datatable();
	}
}