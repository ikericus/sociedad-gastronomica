<?php 

class Model_bookings extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		
		//$this->load->model('model_users');
	}
	
	public function create($data)
	{
		$insert = $this->db->insert('bookings', $data);
		$booking_id = $this->db->insert_id();

		return ($booking_id) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('bookings', $data);
		return ($update == true) ? true : false;	
	}

	public function getBookingData($bookingId = null) 
	{
		if($bookingId) {
			$sql = "SELECT * FROM bookings WHERE id = ?";
			$query = $this->db->query($sql, array($bookingId));
			return $query->row_array();
		}

		$sql = "SELECT * FROM bookings ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getTotalPeopleByDate($date)
	{
		$sql = "SELECT sum(people) totalPeople FROM bookings WHERE date = ?";
		$query = $this->db->query($sql, array($date));
		return $query->row_array()['totalPeople'];
	}
	
	public function fetchBookingsByDate()
	{	
		$sql = "SELECT * FROM bookings WHERE date = ?";
		$query = $this->db->query($sql, array($this->input->post('date')));
		return $query->result_array();
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('bookings');
			return ($delete == true) ? true : false;
		}
	}
}