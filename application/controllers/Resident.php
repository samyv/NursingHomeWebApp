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

    public function questionpage($index)
    {
        if(!is_numeric($index)) return;

        $data['index'] = $index;
        $data['question'] = $this->QuestionModel->getQuestion($index);
        $totalNum = $this->QuestionModel->getNumofQuestionInThisSection($index);
        $data['totalNum'] = $totalNum;
        $currentType = $this->QuestionModel->getQuestionType($index);
        $data['currentType'] = $currentType;
        $previousQuestion = $this->QuestionModel->previousQuestion($index);
        $nextQuestion = $this->QuestionModel->nextQuestion($index);
        if($nextQuestion != -1) {
            $nextType = $this->QuestionModel->getQuestionType($index + 1);

        } else {
            $nextType = $currentType;
        }
        $data['nextType'] = $nextType;
        $data['previousQuestion'] = $previousQuestion;
        $data['nextQuestion'] = $nextQuestion;



        $residentID = $_SESSION['Resident']['residentID'];
        $questionnaireId = $this->QuestionModel->getQuestionnaireID($residentID);
        if($questionnaireId == -1) {
            return;
        }
        $answer = $this->QuestionModel->getAnswer($questionnaireId,$index);
        $pos = $this->QuestionModel->getQuestionPosition($index);
        if($answer == 0) $currentNum = $pos-1;
        else $currentNum = $pos;
        $data['currentNum'] = $currentNum;
        $data['percentage'] = sprintf("%01.0f", ($currentNum/$totalNum)*100).'%';
        $this->parser->parse('Resident/questionPage', $data);
    }

    public function getTotalNum(){
        $index = $this ->input->post('index');
        $data = $this->QuestionModel->getNumofQuestionInThisSection($index);
        echo $data;
    }

    public function tutorialpage(){
        $data['resident'] = $_SESSION['Resident']['residentID'];
        $this->parser->parse("Resident/tutorialPage",$data);
    }

    public function update(){
        $index = $this ->input->post('index');
        $answer = $this->input->post('answer');

        $residentID = $_SESSION['Resident']['residentID'];
        $questionnaireId = $this->QuestionModel->getQuestionnaireID($residentID);
        if($questionnaireId == -1) {
            return;
        }

        $this->QuestionModel->insertIndex($index,$questionnaireId);

        $this->QuestionModel->insertAnswer($questionnaireId, $index, $answer);
        $this->QuestionModel->insertQuestionnaireTimestamp($questionnaireId);

    }

    public function getOldAnswer(){
        $index = $this ->input->post('index');
        $idResident = $_SESSION['Resident']['residentID'];
        $questionnaireID = $this->QuestionModel->getQuestionnaireID($idResident);
        if($questionnaireID == -1) {
            return;
        }
        $data = $this->QuestionModel->getAnswer($questionnaireID, $index);
        echo $data;
    }
    public function getNextQuestionType(){
        $index = $this ->input->post('index');
        $data = $this->QuestionModel->getQuestionType($index+1);
        echo $data;
    }
    public function getCurrentQuestionType(){
        $index = $this ->input->post('index');
        $data = $this->QuestionModel->getQuestionType($index);
        echo $data;
    }


    public function tutorial(){
        //checks if a resident is logged in, else go to the login page
        if(!isset($_SESSION['isResidentLoggedIn'])){
            redirect('resident/index');
        }
        //load the view
        $this->tutorialpage();
    }


    public function logout(){
        $this->session->unset_userdata('isResidentLoggedIn');
        unset($_SESSION['Resident']);
        $this->session->sess_destroy();
        redirect('Resident/index');
    }

    public function section($sectionID, $questionID)
    {
        $data['sectionID'] = $sectionID;
        $data['sectionDescription'] = $this->QuestionModel->getSectionDescription($sectionID);
        $data['index'] = $questionID;
        $data['image'] = $this->QuestionModel->getImage($sectionID);
        $this->load->view('Resident/sectionPage',$data);
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

    public function getIndex()
    {
        $residentID = $_SESSION['Resident']['residentID'];
        $data = $this->QuestionModel->getIndex($residentID);
        echo $data;
    }

    public function finalPage(){
        $idResident = $_SESSION['Resident']['residentID'];
        $questionnaireId = $this->QuestionModel->getQuestionnaireID($idResident);
        $this->QuestionModel->setQuestionnaireCompleted($questionnaireId);
        $index = $this->QuestionModel->getLastQuestion();
        $data['resident'] = $_SESSION['Resident']['firstname'];
        $data['index'] = $index;

        $this->parser->parse('Resident/finalpage',$data);
    }

    public function startQuestionnaire(){
        $idResident = $_SESSION['Resident']['residentID'];
        $this->QuestionModel->createQuestionnaires($idResident);
        $questionnaireId = $this->QuestionModel->getQuestionnaireID($idResident);
        $currentQuestionIndex = $this->QuestionModel->getIndex($idResident);
        $nextQuestionIndex = $this->QuestionModel->nextQuestion($currentQuestionIndex);

        if($nextQuestionIndex == -1){
            $completed = $this->QuestionModel->getQuestionnaireCompleted($questionnaireId);
            if($completed == '0') $this->finalPage();
            else $this->noticePage();
        } else {
            $currentSectionIndex = $this->QuestionModel->getQuestionType($nextQuestionIndex);
            $this->section($currentSectionIndex, $nextQuestionIndex);
        }
    }

    public function checkIfLast(){
        $index = $this->input->post('index');
        $last = $this->QuestionModel->checkIfLast($index);
        if(is_numeric($last)) echo 0;
        else echo 1;
    }

    public function noticePage(){
        print_r("notice page");
    }


}