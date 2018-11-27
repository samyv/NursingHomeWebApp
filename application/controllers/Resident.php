<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 5-11-2018
 * Time: 18:39
 */
//line 91
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

    public function questionpage($index=1)
    {
        $data['question'] = $this->QuestionModel->getQuestion($index);

        $this->parser->parse('Resident/questionPage',$data);
    }

    public function tutorialpage(){
        $data['resident'] = 'Jack';
        $this->parser->parse("Resident/tutorialPage",$data);
    }

    public function update(){
        $index = $this ->input->post('index');
        $answer = $this->input->post('answer');

        $this->QuestionModel->insertIndex($index);
        if($answer != null) {
            $this->QuestionModel->insertAnswer($index - 1, $answer);
            $this->QuestionModel->insertTimestamp();
        }
        $data = $this->QuestionModel->getQuestion($index);
        echo $data;
    }

    public function getOldAnswer(){
        $index = $this ->input->post('index');
        $questionnaireID = 0;
        $data = $this->QuestionModel->getAnswer($questionnaireID, $index);
        echo $data;
    }
    public function getNextQuestionType(){
        $index = $this ->input->post('index');
        $residentID = 1;
        $data = $this->QuestionModel->getQuestionType($index+1);
        echo $data;
    }
    public function getCurrentQuestionType(){
        $index = $this ->input->post('index');
        $residentID = 1;
        $data = $this->QuestionModel->getQuestionType($index);
        echo $data;
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

    public function section($id =1)
    {
        $data['sectionDescription'] = $this->QuestionModel->getSectionDescription($id);
        $data['index'] = $this->getFirstQuestionIndex($id);
        $this->parser->parse('Resident/sectionPage',$data);
    }

    public function getFirstQuestionIndex($id =1)
    {
        for($i =1; $i<50;$i++)
        {
            if($this->QuestionModel->getQuestionType($i) == $id)
            {
                return $i;
            }

        }
        return -1;
    }

    public function getIndex($id =1)
    {
        $residentID = 1;
        $data = $this->QuestionModel->getIndex($residentID);
        echo $data;
    }

    public function finalPage(){
        $data['resident'] = "Jack";
        $this->parser->parse('Resident/finalpage',$data);
    }

}