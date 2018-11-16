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
        $this->load->library('form_validation');
        $this->load->model('residents');
		$this->load->model('QuestionModel');
        $this->load->library('session');
        $this->load->database('default');
    }

    public function index(){
        $data['page_title'] = 'Login resident | GraceAge';
        $data['residentNames'] = array();
        if($this->session->userdata('isUserLoggedIn')){
            redirect('account');
        }


        //get the data from the residents from a certain room, put it in 2 session variables.
        if($this->input->post('loginResident')){
            $this->form_validation->set_rules('room_number', 'Room number', 'required');
            if ($this->form_validation->run() == true) {
                $con['conditions'] = array(
                    'room_number'=>$this->input->post('room_number')
                );
                $residentsInRoom = $this->residents->lookUp($con);
                if($residentsInRoom){
                    foreach ($residentsInRoom as $key => $value){
                        $residentArray[$key] = (array) $value;
                        $_SESSION['Resident'.$key]=(array)$value;
                    }
                    $data['residentNames'] = $residentArray;
                }else{
                    $data['error_msg'] = 'Wrong room number, please try again';
                }
            }
            else {
                echo "validation false";
            }
        }
        //checks which user you pick from the 2, delete the other session variable
        if ($this->input->post('selectResident1')) {
            $_SESSION['Resident']=$_SESSION['Resident0'];
            unset($_SESSION['Resident1']);
            unset($_SESSION['Resident0']);
            $_SESSION['isResidentLoggedIn'] = true;
            redirect('Resident/tutorial');
        }

        if ($this->input->post('selectResident2')) {
            $_SESSION['Resident']=$_SESSION['Resident1'];
            unset($_SESSION['Resident0']);
            unset($_SESSION['Resident1']);
            $_SESSION['isResidentLoggedIn'] = true;
            redirect('Resident/tutorial');
        }

        $this->parser->parse('Resident/login', $data);
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
        if($answer !=null ) {
            $this->insert($index - 1, $answer);
        }
        $data = $this->QuestionModel->getQuestion($index);
        echo $data;
    }

    function insert($index,$answer = '1')
	{
		$this->QuestionModel->insertAnswer($index,$answer);
	}
    public function tutorial(){
        //checks if a resident is logged in, else go to the login page
        if(!isset($_SESSION['isResidentLoggedIn'])){
            redirect('resident/index');
        }
        //load the view
        $this->load->view('Resident/tutorialPage');
    }


    public function logout(){
        $this->session->unset_userdata('isResidentLoggedIn');
        unset($_SESSION['Resident']);
        $this->session->sess_destroy();
        redirect('Resident/index');
    }
}