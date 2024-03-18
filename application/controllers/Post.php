<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('crud');
        $this->load->helper('form');
        $this->load->library('form_validation');
        // if (!$this->ion_auth->logged_in())
		// {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }

    }
	public function index()
	{
		$data['data'] = $this->crud->get_records('posts');
        $this->load->view('post/list',$data);
	}

    public function create() {
        
        $this->load->view('post/create');
    }

    public function store() {
        $this->form_validation->set_rules('title','Title','required|alpha_numeric_spaces');
        $this->form_validation->set_rules('description','Description','required');
        if ($this->form_validation->run()) {
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $this->crud->insert('posts', $data);

            $this->session->set_flashdata('message','<div class="alert alert-success">Record has been saved successfully.</div>');

            redirect(base_url());
            
        } else {
            
            $this->load->view('post/create');

        }
        
        
        
    }

    public function edit($id) {

        $data['data'] = $this->crud->get_post_details('posts',$id);        
        $this->load->view('post/edit',$data);
        
    }

    public function update($id) {


        $data['title'] = $this->input->post('title');   
        $data['description'] = $this->input->post('description');

        $this->crud->update('posts', $id, $data);

        $this->session->set_flashdata('message','<div class="alert alert-success">Record has been updated successfully.</div>');
        redirect(base_url());
        
    }
    public function delete($id) {


        
        $this->crud->delete('posts', $id);

        $this->session->set_flashdata('message','<div class="alert alert-success">Record has been deleted successfully.</div>');
        redirect(base_url());
        
    }

}
