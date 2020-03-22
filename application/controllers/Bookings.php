<?php 

class Bookings extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Reservas';
		
		$this->load->model('model_bookings');
		$this->load->model('model_users');		
		$this->load->model('model_tables');
	}

	public function index()
	{
		$this->render_template('bookings/index', $this->data);
	}

	public function create($date)
	{
		if(!in_array('createBooking', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$this->form_validation->set_rules('people', 'Personas', 'trim|required|numeric');
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	$data = array(
				'date_time'		=> strtotime(date('Y-m-d h:i:s a')),
				'date' 			=> $this->input->post('date'),
				'people' 		=> $this->input->post('people'),
				'user_id'		=> $this->session->userdata('id'),
				'remarks' 		=> $this->input->post('remarks'),
				'timetables'	=> serialize($this->input->post('timetables'))
        	);

			$create = $this->model_bookings->create($data);
			
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Reserva realizada con éxito');
        		redirect('bookings/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('error', 'Ha ocurrido un error');
        		redirect('bookings/create', 'refresh');
        	}
        }
        else {
            // false case
			$this->data['date'] = $date;
			$this->data['totalCapacity'] = $this->model_tables->getTotalCapacity();

            $this->render_template('bookings/create', $this->data);
        }	
	}

	public function edit($id = null)
	{
		if(!in_array('updateBooking', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {
			$this->form_validation->set_rules('people', 'Personas', 'trim|required|numeric');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'date_time'		=> strtotime(date('Y-m-d h:i:s a')),
					'date' 			=> $this->input->post('date'),
					'people' 		=> $this->input->post('people'),
					'user_id'		=> $this->session->userdata('id'),
					'remarks' 		=> $this->input->post('remarks'),
					'timetables'	=> serialize($this->input->post('timetables'))
				);

	        	$update = $this->model_bookings->edit($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Reserva actualizada con éxito');
	        		redirect('bookings/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Ha ocurrido un error');
	        		redirect('bookings/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // false case
				$booking_data = $this->model_bookings->getBookingData($id);				

				$this->data['booking_data'] = $booking_data;
				$this->data['booking_data']['totalCapacity'] =  $this->model_tables->getTotalCapacity();

				$this->render_template('bookings/edit', $this->data);	
	        }	
		}		
	}

	public function getTotalCapacity()
	{
		if(!in_array('viewBooking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_tables->getTotalCapacity();

		echo json_encode($result);
	}

	// public function getTotalCapacityByDate()
	// {
	// 	if(!in_array('viewBooking', $this->permission)) {
	// 		redirect('dashboard', 'refresh');
	// 	}
	// 	$date 			= $this->input->post('date');
	// 	$totalPeople 	= $this->model_bookings->getTotalPeopleByDate($date);
	// 	$totalCapacity 	= $this->model_tables->getTotalCapacity();

	// 	//echo json_encode($totalCapacity - $totalPeople);
	// 	return $totalCapacity - $totalPeople;
	// }

	public function fetchBookingsByDate()
	{
        if(!in_array('viewBooking', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$result = array('data' => array());
		
		$user_id = $this->session->userdata('id');

		$data = $this->model_bookings->fetchBookingsByDate();

		foreach ($data as $key => $value) {

			$user_data = $this->model_users->getUserData($value['user_id']);
			
			$date_time = date('Y-m-d H:i:s', $value['date_time']);

			$buttons = '';

			if(in_array('deleteBooking', $this->permission) and $user_id == $value['user_id']) {
				$buttons .= ' <a href='. base_url('bookings/edit/'.$value['id']) .' class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			if(in_array('updateBooking', $this->permission) and $user_id == $value['user_id']) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$timetables_array = unserialize($value['timetables']);
			$timetables ='';

			if(in_array('almuerzo', $timetables_array)) { $timetables .= 'Almuerzo ';}
			if(in_array('comida', $timetables_array)) 	 { $timetables .= 'Comida ';}
			if(in_array('merienda', $timetables_array)) { $timetables .= 'Merienda ';}
			if(in_array('cena', $timetables_array)) 	 { $timetables .= 'Cena ';}

			$result['data'][$key] = array(
                $user_data['firstname'],
				$value['people'],
				$timetables,
				$value['remarks'],
				$buttons,				
				$date_time
			);
		} // /foreach

		echo json_encode($result);
	}

	public function remove()
	{
		if(!in_array('deleteBooking', $this->permission)) {
		 	redirect('dashboard', 'refresh');
		}
		
		$booking_id = $this->input->post('booking_id');

		$response = array();
		if($booking_id) {
			$delete = $this->model_bookings->remove($booking_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Reserva eliminada";	
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