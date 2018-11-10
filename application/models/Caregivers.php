<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 8-11-2018
 * Time: 16:35
 */

Class Caregivers extends CI_Model{

    function __construct()
    {
        $this->load->database('default');
    }

    function getRows($params= array()){
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            $email = $params['conditions']["email"];
            $password = $params['conditions']["password"];
            $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email' and password = '$password'";
            $result = $this->db->query($sql);
            return $result->num_rows();
        }

        return 0;
    }

    /*
     * Insert user information
     */
    public function insert($data = array()) {
        //add created and modified data if not included
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }

        //insert user data to users table
        $sql = "INSERT INTO Caregiver (idCaregiver, firstname, lastname, email, floor, password, created, modified, status) VALUES (NULL,'$data->firstname','$data->lastname','$data->email','101','$data->password',CURRENT_TIME ,CURRENT_TIME,'0')";
        $insert = $this->db->query($sql);

        print_r($insert->result_id);

        //return the status
        if($insert){
            return $insert->result_id;
        }else{
            return false;
        }
    }

}