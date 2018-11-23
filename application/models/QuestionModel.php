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

    function getAnswer($residentID,$questionNr){
        $query = $this->db->get_where('a18ux02.Questionarries', array('Resident_residentID'=>$residentID));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['Question'.$questionNr];
        }
        return $text;
    }


    function insertAnswer($index,$questionnaireId, $answer){
        $query = $this->db->get_where('a18ux02.Answers', array('questionId'=>$index, 'questionnaireId'=>$questionnaireId));

        $row = $query->row_array();

        if(isset($row)){
            $this->db->query("UPDATE a18ux02.Answers SET answer = $answer WHERE questionId = $index AND questionnaireId = $questionnaireId");
        } else {
            $this->db->query(
                "INSERT INTO a18ux02.Answers (questionId, questionnaireId, answer) VALUE ($index, $questionnaireId, $answer)"
            );
        }

        $this->db->query("UPDATE a18ux02.Answers SET timestamp = CURRENT_TIMESTAMP WHERE questionId = $index AND questionnaireId = $questionnaireId");
    }


    function insertQuestionnaireTimestamp(){
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
            "UPDATE a18ux02.Questionarries SET numOfCurrentQuestion = $index WHERE Resident_residentID = 1"
        );
    }

}