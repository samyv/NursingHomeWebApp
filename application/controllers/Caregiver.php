<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 12/10/2018
 * Time: 14:59
 */

class Caregiver extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
    }
    public function index(){
        $data['page_title']='Login caregiver | GraceAge';
        $this->parser->parse('CGlogin',$data);
    }

    public function register(){
    	$data['page_title'] = 'Register caregiver | GraceAge';
    	$this->parser->parse('CGRegister',$data);
	}

}
