<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends Admin_Controller 
{
	var $currency_code = '';

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Pagos';

		$this->load->model('model_payments');
		$this->load->model('model_users');
      
		$this->currency_code = $this->company_currency();
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewPayment', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Gestionar pagos';
		$this->render_template('payments/index', $this->data);		
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	public function fetchPaymentsData()
	{
		if(!in_array('viewPayment', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$result = array('data' => array());

		$data = $this->model_payments->getPaymentsData();           

		foreach ($data as $key => $value) {

			$user_data = $this->model_users->getUserData($value['user_id']);

			// button
			$buttons = '';

			if(in_array('updatePayment', $this->permission)) {
				$buttons .= ' <a href="'.base_url('payments/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('deletePayment', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$result['data'][$key] = array(
				date('Y-m-d H:i:s', $value['date_time']),
				$value['amount'],
				$user_data['firstname'],
				$value['concept'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createPayment', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('datetime', 'Fecha', 'trim|required');
		$this->form_validation->set_rules('amount', 'Suma', 'trim|required|numeric');
		$this->form_validation->set_rules('user_id', 'Usurio', 'trim|required|numeric');		
	
        if ($this->form_validation->run() == TRUE) {
			
			$datetime = strtotime($this->input->post('datetime'));
			$amount   = $this->input->post('amount');
			$user_id  = $this->input->post('user_id');

			$create = $this->model_payments->create($user_id, $amount, $datetime);
			
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Pago creado con éxito');
        		redirect('payments/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Ha ocurrido un error');
        		redirect('payments/create', 'refresh');
        	}
        }
        else {       	
			
			$this->data['users_data'] = $this->model_users->getUserData();    
			$this->data['date_time'] = date('Y-m-d H:i:s');

            $this->render_template('payments/create', $this->data);
        }	
	}

	public function remove()
	{
		if(!in_array('deletePayment', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$payment_id = $this->input->post('payment_id');

        $response = array();
        if($payment_id) {
            $delete = $this->model_payments->remove($payment_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Pago eliminado con éxito"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Ha ocurrido un error al eliminar el pago";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresca la página";
        }

        echo json_encode($response); 
	}
}