<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('crudajax');
        $this->load->helper('form');
        $this->load->library('form_validation');
        // if (!$this->ion_auth->logged_in())
		// {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }

    }
    public function index() {
        $data['data'] = $this->crudajax->get_records('posts');        
        $this->load->view('ajax/list',$data);
    }

    public function store() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if (!$this->form_validation->run())
        {
        http_response_code(412);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'danger',
            'message' => validation_errors()
        ]);
       

        } else {
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $tr_id = $this->input->post('last_tr_id')+1;
            $id =  $this->crudajax->insert('posts', $data);
            $result = $this->crudajax->get_post_details('posts',$id);

            $html = $result[0]->title;
            $html .= '<tr id="'.$tr_id.'"><td>'.$tr_id.'</td><td>'.$result[0]->title.'</td><td>'.$result[0]->description.'</td><td><a href="http://localhost/crudCodeIgniter/post/edit/'.$id.'" class="btn btn-primary"> <i class="fas fa-edit"></i> Edit </a><a href="http://localhost/crudCodeIgniter/post/delete/'.$id.'" class="btn btn-danger" onclick="return confirm("Are you sure you want to delete this record?")"> <i class="fas fa-trash"></i> Delete </a></td></tr>';






            header('Content-Type: application/json');
            echo json_encode([
                'status' => "success",
                'html'   => $html,
                'message' => "Record has been saved successfully"
            ]);
        }

        
        
    }

    public function delete() {

        $this->crudajax->delete('posts', $this->input->post('id'));
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Deleted'
        ]);    

            
            
    }
}