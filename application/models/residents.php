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

    /*
    * Insert user information
    */
    public function insert($data = array()) {
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthdate = $data['birthdate'];
        $floor = $data['floor'];
        $room = $data['room'];
        $gender = $data['gender'];
        $cp_first_name = $data['cp_first_name'];
        $cp_last_name = $data['cp_last_name'];
        $cp_email = $data['cp_email'];
        $cp_phone = $data['cp_phone'];
        $pictureid = $data['pictureID'];


        // insert contact person in DB
        $sql = "INSERT INTO a18ux02.ContactPerson (firstname, lastname, email, phonenumber) VALUES ('$cp_first_name','$cp_last_name','$cp_email','$cp_phone')";
        $this->db->query($sql);
        $id =$this->db->insert_id();


        //insert resident in resident table
        $sql = "INSERT INTO a18ux02.Resident(residentID, firstname, lastname, birthdate, floor, room, gender,FK_ContactPerson, pictureId) VALUES (NULL, '$firstname','$lastname', '$birthdate', '$floor','$room','$gender','$id','$pictureid')";
        $insert = $this->db->query($sql);

        //return the status
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

    function lookUpEmail($params)
    {
        $sql = "SELECT * FROM a18ux02.ContactPerson WHERE email = '$params'";
        $result = $this->db->query($sql)->result();
        return count($result);
    }

}
