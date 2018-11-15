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
    }

    /*
     * User account information
     */
    public function account(){
        $data = array();
        $userData = array();
        $data['page_title']='Account overview | GraceAge';

        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }


        if($this->session->userdata('isUserLoggedIn')){
            $result = $this->caregivers->getInfo(array('id'=>$this->session->userdata('idCaregiver')));
            $data['caregiver'] = $array = json_decode(json_encode($result['0']), True);
            //load the view
            $this->parser->parse('Caregiver/account', $data);
        }else{
            redirect('index.php');
        }



        if($this->input->post('saveSettings')){
            $idCaregiver = strip_tags($this->input->post('idCaregiver'));
            $this->form_validation->set_rules('firstname', 'First name', 'required');
            $this->form_validation->set_rules('lastname', 'Last name', 'required');
            $this->form_validation->set_rules('floor', 'Floor number', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('old_password', 'old password', 'required|callback_password_check['.$idCaregiver.']');
            if(isset($_POST['new_password'])) {
                $this->form_validation->set_rules('new_password', 'new password', 'required');
                $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[new_password]');
            }

            if($this->form_validation->run() == true) {
                $userData['firstname'] = strip_tags($this->input->post('firstname'));
                $userData['lastname'] = strip_tags($this->input->post('lastname'));
                $userData['email'] = strip_tags($this->input->post('email'));
                $userData['old_password'] = md5($this->input->post('old_password'));
                if (!empty($_POST['new_password'])) {
                    $userData['new_password'] = md5($this->input->post('new_password'));
                }
                $userData['floor'] = strip_tags($this->input->post('floor'));
                $userData['idCaregiver'] = strip_tags($this->input->post('idCaregiver'));
                $insert = $this->caregivers->modify($userData);
                if ($insert) {
                    $this->session->set_userdata('success_msg', 'Your new settings have been saved');
                    //redirect('account');
                } else {
                    $this->session->set_userdata('error_msg', 'Something went wrong...');
                    //redirect('account');
                }
            }
        }
        $data['caregiver'] = $userData;
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
                $con['conditions'] = array(
                    'email'=>$this->input->post('email'),
                    'password' => md5($this->input->post('password'))
                );
                $checkLogin = $this->caregivers->lookUp($con);
                if($checkLogin){
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('idCaregiver',$checkLogin['0']->idCaregiver);
                    $this->session->set_userdata('firstname',$checkLogin['0']->firstname);
                    $this->session->set_userdata('lastname',$checkLogin['0']->lastname);
                    $this->session->set_userdata('floor',$checkLogin['0']->floor);
                    $this->session->set_userdata('email',$checkLogin['0']->email);
                    redirect('landingPage');
                }else{
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }
        //load the view
        //$this->parser->parse('searchForResident.php', $data);
		$this->parser->parse('Caregiver/login', $data);
//        $this->searchForResident();
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
                    redirect('index.php');
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
        redirect('index.php');
    }

    /*
     * Existing email check during validation
     */
    public function email_check($str){
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->caregivers->lookUpEmail($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function password_check($str, $id){

        $con['conditions'] = array('password'=>md5($str),
                                    'id'=>$id);
        $checkPassword = $this->caregivers->lookUpPassword($con);
        if($checkPassword){
            $this->form_validation->set_message('password_check', 'password is incorrect');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function landingPage(){
        $data = array();
        $this->load->view('Caregiver/landingPage');
    }

    public function searchForResident(){

        $data = array();
        $sql = array();
		$this->load->database('default');

        // get names out of database
        $data['name'] = 'Jef';
        $data['page_title']='Login caregiver | GraceAge';

        $result = $this->caregivers->getResidents();
        $data['listCar'] = $result;



        // parse
        $this->parser->parse('searchForResident', $data);
    }

}
