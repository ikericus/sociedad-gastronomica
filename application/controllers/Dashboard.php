<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'Inicio';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
	}

	public function index()
	{
		$user_id = $this->session->userdata('id');

		$this->data['is_admin'] 		= $user_id == 1;
		$this->data['my_debt'] 			= $this->model_orders->sumTotalDebt($user_id) ?? 0;
        $this->data['total_debt'] 		= $this->model_orders->sumTotalDebt() ?? 0;
		$this->data['total_products'] 	= $this->model_products->countTotalProducts();
		$this->data['total_orders'] 	= $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] 		= $this->model_users->countTotalUsers();

		$this->render_template('dashboard', $this->data);
	}
}