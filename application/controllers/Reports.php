<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Informes';
		$this->load->model('model_reports');
	}

	public function storewise()
	{

		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$today_year = date('Y');


		$store_data = $this->model_stores->getStoresData();
		

		$store_id = $store_data[0]['id'];

		if($this->input->post('select_store')) {
			$store_id = $this->input->post('select_store');
		}

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$order_data = $this->model_reports->getStoreWiseOrderData($today_year, $store_id);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($order_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['net_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}

		$this->data['selected_store'] = $store_id;
		$this->data['store_data'] = $store_data;
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;
		
		$this->render_template('reports/storewise', $this->data);
	}

	public function debts()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('reports/debts', $this->data);
	}

	public function intakes()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$order_data = $this->model_reports->getIntakesData($today_year);

		$final_order_data = array();
		foreach ($order_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['net_amount'];						
					}
				}
				$final_order_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_order_data[$k] = 0;	
			}			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['results'] = $final_order_data;

        $this->render_template('reports/intakes', $this->data);
	}

	public function topproducts()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->render_template('reports/topproducts', $this->data);
	}

	public function fetchDebtsData()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_reports->getDebtsData();           

		foreach ($data as $key => $value) {            
          
			$result['data'][$key] = array(
				$value['usuario'],
                $value['deuda']
			);
		} // /foreach

		echo json_encode($result);
	}

	
	public function fetchTopProductsData()
	{
		if(!in_array('viewReport', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_reports->getTopProductsData();           

		foreach ($data as $key => $value) {            
          
			$result['data'][$key] = array(
				$value['producto'],
                $value['consumo']
			);
		} // /foreach

		echo json_encode($result);
	}
}	