<?php 

class Tables extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Mesas';
		$this->load->model('model_tables');
	}

	public function index()
	{	
		$this->render_template('tables/index', $this->data);
	}

	public function fetchTableData()
	{
		if(!in_array('viewTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$result = array('data' => array());

		$data = $this->model_tables->getTableData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateTable', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteTable', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$available = ($value['available'] == 1) ? '<span class="label label-success">Disponible</span>' : '<span class="label label-warning">No disponible</span>';
			$status = ($value['active'] == 1) ? '<span class="label label-success">Activa</span>' : '<span class="label label-warning">Inactiva</span>';

			$result['data'][$key] = array(
				$value['table_name'],
				$value['capacity'],
				// $available,
				// $status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('table_name', 'Table name', 'trim|required');
		$this->form_validation->set_rules('capacity', 'Capacity', 'trim|integer');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'table_name' => $this->input->post('table_name'),
        		'available' => 1,
        		'capacity' => $this->input->post('capacity'),	
        		'active' => $this->input->post('active')
        	);

        	$create = $this->model_tables->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Mesa creada con éxito';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Ha ocurrido un error';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	public function fetchTableDataById($id = null)
	{
		if($id) {
			$data = $this->model_tables->getTableData($id);
			echo json_encode($data);
		}
		
	}

	public function update($id)
	{
		if(!in_array('updateTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_table_name', 'Table name', 'trim|required');
			$this->form_validation->set_rules('edit_capacity', 'Capacity', 'trim|integer');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
			//$this->form_validation->set_rules('edit_store', 'Store', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'table_name' => $this->input->post('edit_table_name'),
        			'capacity' => $this->input->post('edit_capacity'),	
        			'active' => $this->input->post('edit_active')	
	        	);

	        	$update = $this->model_tables->update($id, $data);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Mesa actualizada con éxito';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Ha ocurrido un error';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Ha ocurrido un error, por favor refresca la página';
		}

		echo json_encode($response);
	}

	public function remove()
	{
		if(!in_array('deleteTable', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$table_id = $this->input->post('table_id');

		$response = array();
		if($table_id) {
			$delete = $this->model_tables->remove($table_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Mesa eliminado con éxito";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Ha ocurrido un error";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Ha ocurrido un error, por favor refresca la página";
		}

		echo json_encode($response);
	}

}