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


    function getQuestion(){
        $query = $this->db->query("SELECT * FROM a18ux02.Question where idQuestion = 1");

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['questionText'];
        }
        return $text;
    }

    function insertAnswer($answer){
        $this->db->query(
            'INSERT INTO a18ux02.Questionarries (Question1) VALUES (?)', $answer
        );
    }
}