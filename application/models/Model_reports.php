<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYear()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('Y', $v['date_time']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths
	public function getOrderData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	

			return $final_data;
		}
	}

	public function getStoreWiseOrderData($year, $store)
	{
		if($year && $store) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ? AND store_id = ?";
			$query = $this->db->query($sql, array(1, $store));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	
			
			return $final_data;
		}
	}
	
	public function getDebtsData()
	{
		$sql = "SELECT users.firstname as usuario, ROUND(A.ordenes - B.pagos, 2) as deuda FROM users LEFT JOIN (	SELECT users.id as id, COALESCE(SUM(orders.net_amount), 0) as ordenes FROM users LEFT JOIN orders on users.id = orders.user_id GROUP BY users.id ) AS A ON users.id = A.id LEFT JOIN (	SELECT users.id as id, COALESCE(SUM(payments.amount), 0) as pagos FROM users LEFT JOIN payments on users.id = payments.user_id GROUP BY users.id) AS B ON users.id = B.id ORDER BY deuda DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getTopProductsData()
	{
		$sql = "SELECT p.name as producto, SUM(oi.qty) as consumo FROM order_items AS oi JOIN orders AS o ON oi.order_id = o.id JOIN products AS p ON oi.product_id = p.id GROUP BY p.id ORDER BY consumo DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getIntakesData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	

			return $final_data;
		}
	}
}