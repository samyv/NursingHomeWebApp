<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 13-11-2018
 * Time: 12:37
 */

class residents extends CI_Model
{
    function __construct()
    {
        $this->load->database('default');
    }

    function lookUp($params= array()){
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            $room = $params['conditions']["room_number"];
            $sql = "SELECT * FROM a18ux02.Resident WHERE room = '$room'";
            $result = $this->db->query($sql)->result();
            return $result;
        }
        return 0;
    }

}