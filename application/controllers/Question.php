<?php
/**
 * Created by PhpStorm.
 * User: liuliyang
 * Date: 11/13/18
 * Time: 1:00 PM
 */
class Question extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->model('QuestionModel');
    }

    public function page($index=1)
    {
        $data['question'] = $this->QuestionModel->getQuestion($index);

        $this->parser->parse('Resident/questionPage',$data);
//        $data['question'] = $this->QuestionModel->get_all_questions(); // get results array from model
//        $this->load->view('Resident/questionPage', $data); // pass array to view
    }

    public function update(){
        $index =$this ->input->post('index');
        $data = $this->QuestionModel->getQuestion($index);
        echo $data;
    }

    function insert($answer = '1'){
        $this->QuestionModel->insertAnswer($answer);
    }
}