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
        $this->load->library('form_validation');
    }

    public function account(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));
            //load the view
            $this->load->view('Caregiver/account', $data);
        }else {
            redirect('Caregiver/index');
        }
    }
    public function index(){

        $data['page_title']='Login caregiver | GraceAge';
        $this->parser->parse('Caregiver/login',$data);
    }

    public function register(){
    	$data['page_title'] = 'Register caregiver | GraceAge';
    	$this->parser->parse('Caregiver/register',$data);
	}



}
