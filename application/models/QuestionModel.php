<?php
/**
 * Created by PhpStorm.
 * User: liuliyang
 * Date: 11/13/18
 * Time: 9:08 AM
 */
date_default_timezone_set('Europe/Brussels');
class QuestionModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database('default');

    }


    function getQuestion($questionID){
        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$questionID));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['questionText'];
        }
        return $text;
    }

    function getQuestionType($questionID){
        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$questionID));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['questionType'];
        }

        return $text;
    }

    function getAnswer($questionnaireID,$questionNr){
        $query = $this->db->get_where('a18ux02.Answers', array('questionnairesId'=>$questionnaireID, 'questionId'=>$questionNr));

        $row = $query->row_array();

        $answer = 0;

        if (isset($row))
        {
            $answer = $row['answer'];
        }
        return $answer;
    }


    function insertAnswer($questionnaireId,$index,$answer){
        if(!is_numeric($answer) || $answer>5 || $answer<1) return;

        $query = $this->db->get_where('a18ux02.Answers', array('questionnairesId'=>$questionnaireId, 'questionId'=>$index));

        $row = $query->row_array();

        if (isset($row))
        {
            $this->db->query(
                "UPDATE a18ux02.Answers SET answer = $answer WHERE questionnairesId = $questionnaireId AND questionId = $index"
            );
            $this->db->query(
                "UPDATE a18ux02.Answers SET timestamp = CURRENT_TIMESTAMP WHERE questionnairesId = $questionnaireId AND questionId = $index"
            );
        } else {
            $this->db->query("INSERT INTO a18ux02.Answers (questionnairesId, questionId, timestamp, answer) VALUES ($questionnaireId, $index, CURRENT_TIMESTAMP, $answer)");
        }

    }


    function insertQuestionnaireTimestamp($questionnaireId){
        $this->db->query(
            "UPDATE a18ux02.Questionnaires SET timestamp = CURRENT_TIMESTAMP WHERE idQuestionnaires = $questionnaireId"
        );
    }

    function getSectionDescription($id){
        $query = $this->db->get_where('a18ux02.Section', array('sectionId'=>$id));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['sectionText'];
        }
        return $text;
    }
    function getImage($id){
        $query = $this->db->get_where('a18ux02.Section', array('sectionId'=>$id));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['sectionIcon'];
        }
        return $text;
    }

    function getIndex($residentID){
        $query = $this->db->query("SELECT * FROM a18ux02.Questionnaires WHERE Resident_residentID = $residentID ORDER BY timestamp DESC LIMIT 1");

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['numOfCurrentQuestion'];
        }
        return $text;
    }

    function insertIndex($index, $questionnaireID){
        if(!is_numeric($index) || $index<0) return;
        $query = $this->db->query("SELECT * FROM a18ux02.Questionnaires WHERE idQuestionnaires = $questionnaireID ORDER BY timestamp DESC LIMIT 1");

        $row = $query->row_array();

        if($index > $row['numOfCurrentQuestion']) {
            $this->db->query(
                "UPDATE a18ux02.Questionnaires SET numOfCurrentQuestion = $index WHERE idQuestionnaires = $questionnaireID"
            );
        }
    }

    function createQuestionnaires($residentID){
        if(!is_numeric($residentID) || $residentID<0) return;

        $query = $this->db->query("SELECT * FROM a18ux02.Questionnaires WHERE Resident_residentID = $residentID ORDER BY timestamp DESC LIMIT 1");

        $row = $query->row_array();

        if(isset($row)){
            $now = new DateTime(date('Y-m-d H:i:s e'));
            $lastTime = new DateTime($row['timestamp']);
            $interval = $lastTime->diff($now);
            if($interval->d*24+$interval->h > 24){
                $this->db->query("INSERT INTO a18ux02.Questionnaires (Resident_residentID, timestamp, numOfCurrentQuestion) VALUE ($residentID, CURRENT_TIMESTAMP , 0)");
            }
        } else {
            $this->db->query("INSERT INTO a18ux02.Questionnaires (Resident_residentID, timestamp, numOfCurrentQuestion) VALUE ($residentID, CURRENT_TIMESTAMP , 0)");
        }
    }

    function getNumofQuestionInThisSection($index){
        $type = $this->getQuestionType($index);
        $query = $this->db->query("SELECT * FROM a18ux02.Question where questionType = $type");
        return $query->num_rows();
    }

    function getQuestionnaireID($residentID){
        if(!is_numeric($residentID) || $residentID<0) return;

        $query = $this->db->query("SELECT * FROM a18ux02.Questionnaires WHERE Resident_residentID = $residentID ORDER BY timestamp DESC LIMIT 1");

        $row = $query->row_array();

        $questionnaireID = -1;

        if(isset($row)){
            $questionnaireID = $row['idQuestionnaires'];
        }

        return $questionnaireID;
    }

    function checkIfLast($index){
        $re = '';

        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$index));

        $row = $query->row_array();

        if(isset($row)){
            $re = $row['nextQuestionId'];
        }

        return $re;
    }

    function getQuestionPosition($questionID){
        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$questionID));

        $row = $query->row_array();

        $pos = 0;

        if(isset($row)){
            $pos = $row['positionNum'];
        }

        return $pos;
    }

    function getResidentFirstName($ID){
        $query = $this->db->get_where('a18ux02.Resident', array('residentID'=>$ID));

        $row = $query->row_array();

        $pos = 0;

        if(isset($row)){
            $pos = $row['firstname'];
        }

        return $pos;
    }

    function getFirstQuestion(){
        $query = $this->db->get_where('a18ux02.Question', array('previousQuestionId'=>'NULL'));

        $row = $query->row_array();

        $id = -1;

        if(isset($row)){
            $id = $row['idQuestion'];
        }

        return $id;
    }

    function getLastQuestion(){
        $query = $this->db->get_where('a18ux02.Question', array('nextQuestionId'=>'NULL'));

        $row = $query->row_array();

        $id = -1;

        if(isset($row)){
            $id = $row['idQuestion'];
        }

        return $id;
    }

    function nextQuestion($index){
        if($index==0) return $this->getFirstQuestion();

        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$index));

        $row = $query->row_array();

        $next = -1;

        if(isset($row)){
            $next = $row['nextQuestionId'];
        }

        if($next == 'NULL') $next = -1;

        return $next;
    }

    function previousQuestion($index){
        if($index==0) return -1;

        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$index));

        $row = $query->row_array();

        $prev = -1;

        if(isset($row)){
            $prev = $row['previousQuestionId'];
        }

        if($prev == 'NULL') $prev = -1;

        return $prev;
    }

    function setQuestionnaireCompleted($questionnaireId){
        $query = $this->db->get_where('a18ux02.Questionnaires',array('idQuestionnaires'=>$questionnaireId));

        $row = $query->row_array();

        if(isset($row)){
            $this->db->query("UPDATE a18ux02.Questionnaires SET Completed = '1' WHERE idQuestionnaires = $questionnaireId");
        }
    }

    function getQuestionnaireCompleted($questionnaireId){
        $query = $this->db->get_where('a18ux02.Questionnaires',array('idQuestionnaires'=>$questionnaireId));

        $row = $query->row_array();

        $completed = -1;

        if(isset($row)){
            $completed = $row['Completed'];
        }

        return $completed;
    }

}