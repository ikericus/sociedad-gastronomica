<?php 

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		//$this->load->model('model_tables');
		$this->load->model('model_users');
	}

	/* get the orders data */
	public function getOrdersData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM orders WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$user_id = $this->session->userdata('id');
		$sql = "SELECT * FROM orders ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM order_items WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		// get store id from user id 
		$user_data = $this->model_users->getUserData($user_id);

		$bill_no = $this->config->item('acronym_name').'-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
    	$data = array(
    		'bill_no' => $bill_no,
    		'date_time' => strtotime(date('Y-m-d h:i:s a')),
    		'net_amount' => $this->input->post('net_amount_value'),
    		'paid_status' => 2,
    		'user_id' => $user_id
    	);

		$insert = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();

		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate_value')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);

    		$this->db->insert('order_items', $items);
    	}
		return ($order_id) ? $order_id : false;
	}
  
    public function sumTotalDebt($user_id = null)
	{
		if($user_id) {
			$sql = "SELECT SUM(net_amount) AS suma FROM orders WHERE user_id = ?";
			$query = $this->db->query($sql, array($user_id));
			$orders_amount = $query->row()->suma;
			
			$sql = "SELECT SUM(amount) AS suma FROM payments WHERE user_id = ?";
			$query = $this->db->query($sql, array($user_id));
			$payments_amount = $query->row()->suma;

			return $orders_amount - $payments_amount;
		}
		else
		{
			$sql = "SELECT SUM(net_amount) AS suma FROM orders";
			$query = $this->db->query($sql);
			$orders_amount = $query->row()->suma;
			
			$sql = "SELECT SUM(amount) AS suma FROM payments";
			$query = $this->db->query($sql);
			$payments_amount = $query->row()->suma;

			return $orders_amount - $payments_amount;
		}
	}
  
	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM order_items WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if($id) {
			//$user_id = $this->session->userdata('id');
			//$user_data = $this->model_users->getUserData($user_id);

			$order_data = $this->getOrdersData($id);

			$data = array(
	    		'net_amount' => $this->input->post('net_amount_value'),
				'paid_status' => $this->input->post('paid_status')
				//, 'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('order_items');

			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('order_items', $items);
	    	}	    	

			return true;
		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('order_items');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}