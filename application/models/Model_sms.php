<?php 

class Model_sms extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function add($sender, $body)
	{
    	$data = array(
    		'date_time' => strtotime(date('Y-m-d h:i:s a')),
    		'sender' 	=> $sender,
    		'body' 		=> $body
    	);

		$insert = $this->db->insert('sms', $data);
		$sms_id = $this->db->insert_id();

		return ($sms_id) ? $sms_id : false;
	}
}