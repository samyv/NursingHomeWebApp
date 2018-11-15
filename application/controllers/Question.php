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

    public function page()
    {
        $data['question'] = $this->QuestionModel->getQuestion();

        $this->parser->parse('Resident/questionPage',$data);
    }

    function insert($answer = '1'){
        $this->QuestionModel->insertAnswer($answer);
    }
}