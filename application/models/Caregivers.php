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

    function getInfo($params = array()){
        if(array_key_exists("id", $params)){
            $id=$params['id'];
            $sql = "Select * from a18ux02.Caregiver where idCaregiver = '$id'";
            $result = $this->db->query($sql)->result();
            return $result;
        }
    }
    function lookUp($params= array()){
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            $email = $params['conditions']["email"];
            $password = $params['conditions']["password"];
            $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email' and password = '$password'";
            $result = $this->db->query($sql)->result();
            return $result;
        }
        return 0;
    }

    function lookUpEmail($params= array()){
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            $email = $params['conditions']["email"];
            $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email'";
            $result = $this->db->query($sql)->result();
            return count($result);
        }
    }

    /*
     * Insert user information
     */
    public function insert($data = array()) {
        //add created and modified data if not included
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $password = $data['password'];
        //insert user data to users table
        $sql = "INSERT INTO a18ux02.Caregiver (idCaregiver, firstname, lastname, email, floor, password, created, modified, status) VALUES (NULL,'$firstname','$lastname','$email','101','$password',CURRENT_TIME ,CURRENT_TIME,'0')";
        $insert = $this->db->query($sql);
        print_r($insert);

        //return the status
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

}