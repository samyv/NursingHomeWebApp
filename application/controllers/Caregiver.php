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
        $this->load->model('caregivers');
        $this->load->library('session');
        $this->load->database('default');
        $userData = array();
    }

    /*
     * User account information
     */
    public function account(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $result = $this->caregivers->getInfo(array('id'=>$this->session->userdata('idCaregiver')));
            $data['caregiver'] = $array = json_decode(json_encode($result['0']), True);
            //load the view
            $this->load->view('Caregiver/account', $data);
        }else{
            redirect('index');
        }
    }

    /*
     * User login
     */
    public function index(){
        $data = array();
        $data['page_title']='Login caregiver | GraceAge';
        if($this->session->userdata('isUserLoggedIn')){
            redirect('account');
        }
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        if($this->input->post('loginSubmit')){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == true) {
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'email'=>$this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    'status' => '1'
                );
                $checkLogin = $this->caregivers->lookUp($con);
                if($checkLogin){
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('idCaregiver',$checkLogin['0']->idCaregiver);
                    redirect('account/');
                }else{
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }
        //load the view
        $this->parser->parse('Caregiver/login', $data);
    }

    /*
     * User registration
     */
    public function register(){
        $data = array();
        $userData = array();
        $data['page_title']='Register new caregiver | GraceAge';
        if($this->input->post('regisSubmit')){
            $this->form_validation->set_rules('firstname', 'Name', 'required');
            $this->form_validation->set_rules('lastname', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');
            if($this->form_validation->run() == true){
                $userData = array(
                    'firstname' => strip_tags($this->input->post('firstname')),
                    'lastname' => strip_tags($this->input->post('lastname')),
                    'email' => strip_tags($this->input->post('email')),
                    'password' => md5($this->input->post('password')),
                );
                $insert = $this->caregivers->insert($userData);
                if($insert){
                    $this->session->set_userdata('success_msg', 'Your registration was successfully. Please login to your account.');
                    redirect('index');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }

        }
        $data['caregiver'] = $userData;
        //load the view
        $this->parser->parse('Caregiver/register', $data);
    }

    /*
     * User logout
     */
    public function logout(){
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('idCaregiver');
        $this->session->sess_destroy();
        redirect('index');
    }

    /*
     * Existing email check during validation
     */
    public function email_check($str){
        $con['returnType'] = 'count';
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->caregivers->lookUpEmail($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
