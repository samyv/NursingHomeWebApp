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

        $text = '';

        if (isset($row))
        {
            $text = $row['answer'];
        }
        return $text;
    }


    function insertAnswer($questionnaireId,$index,$answer){
        $this->db->query(
            "UPDATE a18ux02.Answers SET Question".$index." = ".$answer." WHERE Resident_residentID = 1"
        );
    }


    function insertTimestamp(){
        $this->db->query(
            "UPDATE a18ux02.Questionarries SET timestamp = CURRENT_TIMESTAMP WHERE Resident_residentID = 1"
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
        $this->db->query(
            "UPDATE a18ux02.Questionarries SET numOfCurrentQuestion = ".$index." WHERE Resident_residentID = 1"
        );
    }

}