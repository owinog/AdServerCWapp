<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Answer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function mark_as_correct()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}
		$answer_id = $this->input->post('answer_id');
		$question_id = $this->input->post('question_id');
		$this->Answer_model->mark_as_correct($answer_id, $question_id, $this->session->userdata('user_id'));
		redirect('question/view/' . $question_id);
	}
	public function delete_answer()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('home');
		}
		$answer_id = $this->input->post('answer_id');
		$this->Answer_model->delete_answer($answer_id);
	}
	public function set_previous_url()
	{
		$this->session->set_userdata('previous_url', current_url());
	}
}
