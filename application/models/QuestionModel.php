<?php
/**
 * Created by PhpStorm.
 * User: liuliyang
 * Date: 11/13/18
 * Time: 9:08 AM
 */

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
        $query = $this->db->get_where('a18ux02.Answers', array('questionnaireId'=>$questionnaireID, 'questionId'=>$questionNr));

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

        $query = $this->db->get_where('a18ux02.Answers', array('questionnaireId'=>$questionnaireId, 'questionId'=>$index));

        $row = $query->row_array();

        if (isset($row))
        {
            $this->db->query(
                "UPDATE a18ux02.Answers SET answer = $answer WHERE questionnaireId = $questionnaireId AND questionId = $index"
            );
            $this->db->query(
                "UPDATE a18ux02.Answers SET timestamp = CURRENT_TIMESTAMP WHERE questionnaireId = $questionnaireId AND questionId = $index"
            );
        } else {
            $this->db->query("INSERT INTO a18ux02.Answers (questionnaireId, questionId, timestamp, answer) VALUES ($questionnaireId, $index, CURRENT_TIMESTAMP, $answer)");
        }

    }


    function insertTimestamp($residentID){
        $this->db->query(
            "UPDATE a18ux02.Questionarries SET timestamp = CURRENT_TIMESTAMP WHERE Resident_residentID = $residentID"
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
        $query = $this->db->get_where('a18ux02.Questionarries', array('Resident_residentID'=>$residentID));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['numOfCurrentQuestion'];
        }
        return $text;
    }

    function insertIndex($index){
        if(!is_numeric($index) || $index<0) return;
        $this->db->query(
            "UPDATE a18ux02.Questionarries SET numOfCurrentQuestion = ".$index." WHERE Resident_residentID = 1"
        );
    }

    function createQuestionnaires($residentID){
        if(!is_numeric($residentID) || $residentID<0) return;

        $query = $this->db->query("SELECT * FROM a18ux02.Questionarries WHERE Resident_residentID = $residentID ORDER BY timestamp DESC LIMIT 1");

        $row = $query->row_array();

        if(isset($row)){
            $now = new DateTime(date('Y-m-d H:i:s e'));
            $lastTime = new DateTime($row['timestamp']);
            $interval = $lastTime->diff($now);
            if($interval->format('%a') > 7){
                $this->db->query("INSERT INTO a18ux02.Questionarries (Resident_residentID, timestamp, numOfCurrentQuestion) VALUE ($residentID, CURRENT_TIMESTAMP , 0)");
            }
        } else {
            $this->db->query("INSERT INTO a18ux02.Questionarries (Resident_residentID, timestamp, numOfCurrentQuestion) VALUE ($residentID, CURRENT_TIMESTAMP , 0)");
        }
    }

    function getNumofQuestionInThisSection($index){
        $type = $this->getQuestionType($index);
        $query = $this->db->query("SELECT * FROM a18ux02.Question where questionType = $type");
        return $query->num_rows();
    }

    function getQuestionnaireID($residentID){
        if(!is_numeric($residentID) || $residentID<0) return;

        $query = $this->db->get_where('a18ux02.Questionarries', array('Resident_residentID'=>$residentID));

        $row = $query->row_array();

        $questionnaireID = -1;

        if(isset($row)){
            $questionnaireID = $row['idQuestionarries'];
        }

        return $questionnaireID;
    }

}