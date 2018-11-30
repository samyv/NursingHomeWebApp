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

        //insert user data in resident table
        $sql = "INSERT INTO a18ux02.Resident(residentID, firstname, lastname, birthdate, floor, room, gender) VALUES (NULL, '$firstname','$lastname', '$birthdate', '$floor','$room','$gender')";
        $insert = $this->db->query($sql);

        //return the status
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

}
