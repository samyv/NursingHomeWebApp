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

    public function page()
    {
        $data['question'] = $this->QuestionModel->getQuestion();

        $this->parser->parse('Resident/questionPage',$data);
    }

    function insert($answer = '1'){
        $this->QuestionModel->insertAnswer($answer);
    }
}