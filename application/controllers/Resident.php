<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 5-11-2018
 * Time: 18:39
 */

class Resident extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->model('QuestionModel');
    }

    public function index(){
        $data['page_title'] = 'Login resident | GraceAge';
        $this->parser->parse('Rlogin', $data);
    }

    public function page($index=1)
    {
        $data['question'] = $this->QuestionModel->getQuestion($index);

        $this->parser->parse('Resident/questionPage',$data);
        //        $data['question'] = $this->QuestionModel->get_all_questions(); // get results array from model
        //        $this->load->view('Resident/questionPage', $data); // pass array to view
    }

    public function update(){
        $index = $this ->input->post('index');
        $answer = $this->input->post('answer');
        $this->insert($index-1, $answer);
        $data = $this->QuestionModel->getQuestion($index);
        echo $data;
    }

    function insert($index,$answer){
        $this->QuestionModel->insertAnswer($index,$answer);
    }
}