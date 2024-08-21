<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_types_model extends MY_Model {

    public $table = USER_TYPES_TABLE." AS ut";
	public $select_column = ['ut.id', 'ut.type_name', 'ut.is_super_admin'];
	public $search_column = ['ut.id', 'ut.type_name'];
    public $order_column = [null, 'ut.type_name', null];

	public $order = ['ut.id' => 'ASC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'ut.id')
				 ->from($this->table)
				 ->where(['ut.is_delete' => 0]);

		if($count === false) $this->datatable();
	}
}