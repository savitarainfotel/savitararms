<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sent_invites_model extends MY_Model {
    public $table = SEND_INVITES_TABLE." AS i";
	public $select_column = ['i.id', 'CONCAT(p.name, " - ", hosted_on) AS property_name', 'i.status', 'rp.platform', 'i.rating', 'i.comments', 'i.created_at', 'c.first_name', 'c.last_name', 'p.client_id', 'iu.name', 'iu.email', 'iu.phone'];
	public $search_column = ['p.name', 'i.status', 'i.created_at', 'c.first_name', 'c.last_name', 'rp.platform', 'i.rating', 'i.comments'];
    public $order_column = [null, 'p.name', 'i.status', 'rp.platform', 'i.rating', 'i.comments', 'i.created_at', 'c.first_name', null];

	public $order = ['i.id' => 'DESC'];

	public function make_query($count = false)
	{
		$this->db->select($count === false ? $this->select_column : 'i.id')
				 ->from($this->table)
				 ->where('i.is_delete', 0)
                 ->join(PROPERTIES_TABLE.' AS p', 'p.id = i.property_id')
                 ->join(RATING_PLATFORMS_TABLE.' AS rp', 'rp.id = i.rating_platform_id', 'LEFT')
                 ->join(USERS_TABLE.' AS c', 'c.id = p.client_id')
				 ->join(INVITES_TABLE.' AS iu', 'iu.id = i.invite_id');

		if(!$this->user->is_admin && !$this->user->is_super_admin) {
			$this->db->where('p.client_id', $this->user->id);
		}

		if($this->input->post('invite_id')) {
			$this->db->where('i.invite_id', d_id($this->input->post('invite_id')));
		}

		if($count === false) $this->datatable();
	}

	public function send_invites(&$postArray, &$inviteData)
	{
		$send_invite_ids = [];

		$this->db->trans_start();

		foreach($postArray['property_ids'] as $property_id) {
			$insertArray = [
				'invite_id'     => $postArray['invite_id'],
				'property_id'   => $property_id
			];

			$send_invite_id = $this->add($insertArray, SEND_INVITES_TABLE);

			$send_invite_ids[] = [
				'send_invite_id' => $send_invite_id,
				'platforms' 	 => $this->generalmodel->getRatingPlatforms($property_id, 1)
			];
		}

		$this->db->trans_complete();

		$trans_status = $this->db->trans_status();

		if($trans_status === true) {
			$this->load->library('appmails');

			foreach ($send_invite_ids as $send_invite_id) {
				$email_settings = [];
				foreach ($send_invite_id['platforms'] as $platform) {
					if(empty($platform['setting'])) continue;
					$email_settings[] = $platform;
				}

				if(!empty($email_settings) && $this->appmails->send_invites($inviteData, $send_invite_id['send_invite_id'])) {
					$this->update(['id' => $send_invite_id['send_invite_id']], ['status' => 'Email Sent'], SEND_INVITES_TABLE);
				}
			}
		}

		return $trans_status;
	}
}