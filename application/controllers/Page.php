<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
	public function index()
	{
		$data['meta'] = [
			'title' => 'Arlis Coder',
		];

		$this->load->view('home', $data);
	}

	public function about()
	{
		$data['meta'] = [
			'title' => 'About Arliscoder.dev',
		];

		$this->load->view('about', $data);
	}

	public function contact()
	{
		$data['meta'] = [
			'title' => 'Contact Us',
		];
		$this->load->library('form_validation');
		
		if ($this->input->method() === 'post') {
			$this->load->model('feedback_model');
			// @TODO: lakukan validasi di sini sebelum insert ke model
			$rules = $this->feedback_model->rules();
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run() == FALSE) {
				return $this->load->view('contact', $data);
			}
			
			$feedback = [
				'id' => uniqid('', true), // genearate id unik
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'message' => $this->input->post('message')
			];
			
			$feedback_saved = $this->feedback_model->insert($feedback);
			
			if ($feedback_saved) {
				return $this->load->view('contact_thanks');
			}
		}
		$this->load->view('contact', $data);
	}
}