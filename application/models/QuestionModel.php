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


    function getQuestion($index ){
        $query = $this->db->get_where('a18ux02.Question', array('idQuestion'=>$index));

        $row = $query->row_array();

        $text = '';

        if (isset($row))
        {
            $text = $row['questionText'];
        }
        return $text;
    }


    function insertAnswer($index,$answer){
        $this->db->query(
            "UPDATE a18ux02.Questionarries SET Question".$index." = ".$answer." WHERE Resident_residentID = 1"
        );
    }
}