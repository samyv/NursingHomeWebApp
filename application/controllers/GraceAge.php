<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 12/10/2018
 * Time: 14:59
 */

class GraceAge extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->model('Menu_model');
    }
    public function index(){
        $data['page_title']='Login | GraceAge';
        $this->parser->parse('Login',$data);
    }

    public function pw_forgotten(){
        $data['page_title']='Forgot password | GraceAge';
        $this->parser->parse('ForgotPW',$data);
    }

}