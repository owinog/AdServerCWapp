<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Question extends CI_Controller
{
	protected $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['username'] = $this->session->userdata('username');
		date_default_timezone_set('Asia/Colombo');
		$this->data['showForm'] = false;
	}
	public function show_answer_form($question_id)
	{
		if (!$this->session->userdata('user_id')) {
			$this->set_previous_url();
			redirect('login');
		}
		$this->data['question_id'] = $question_id;
		$question = $this->Question_model->get_question($question_id);
		$this->data['question'] = $question;
		$this->data['showForm'] = true;
		log_message('debug', 'Answer form loaded');
		$this->load->view('question', $this->data);
	}
	public function answer_question($question_id)
	{
		$this->form_validation->set_rules('answer', 'Answer', 'required');
		$answer = $this->input->post('answer');
		if ($this->form_validation->run() == FALSE) {
			$this->show_answer_form($question_id);
		} else {
			$user_id = $this->session->userdata('user_id');
			$this->Answer_model->answer_question($answer, $question_id, $user_id);
			log_message('debug', 'Answer Added');
			redirect('question/view/' . $question_id);
		}
	}
	public function view_question($id)
	{
		$question = $this->Question_model->get_question($id);
		$this->data['question'] = $question;
		log_message('debug', 'Question view loading');
		$this->load->view('question', $this->data);
	}
	public function mark_as_solved()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('home');
		}
		$question_id = $this->input->post('question_id');
		$this->Question_model->mark_as_solved($question_id);
	}
	public function delete_question()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('home');
		}
		$question_id = $this->input->post('question_id');
		$this->Question_model->delete_question($question_id);
	}
	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}
