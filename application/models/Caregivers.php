<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 8-11-2018
 * Time: 16:35
 */

Class Caregivers extends CI_Model{


    private $notes;

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

    function lookUpPassword($params= array()){
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            $password = $params['conditions']["password"];

            $id = $params['conditions']["id"];
            $sql = "SELECT password FROM a18ux02.Caregiver WHERE idCaregiver = '$id'";
            $result = $this->db->query($sql)->result();
            if($password != $result['0']->password){
                return true;
            } else {
                return false;
            }

        }
    }

    /*
     * Insert user information
     */
    public function insert($data = array()) {
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $password = $data['password'];
        //insert user data to users table
        $sql = "INSERT INTO a18ux02.Caregiver (idCaregiver, firstname, lastname, email, floor, password, created, modified, activated) VALUES (NULL,'$firstname','$lastname','$email','1','$password',CURRENT_TIME ,CURRENT_TIME,'0')";
        $insert = $this->db->query($sql);
        print_r($insert);

        //return the status
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

    public function modify($data = array()) {
        $idCaregiver = $data['idCaregiver'];
        $firstname = $data['firstname'];
        $floor= $data['floor'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $oldPassword = $data['old_password'];

        if(!empty($data['new_password'])) {
            $newPassword = $data['new_password'];
            $sql = "UPDATE a18ux02.Caregiver 
                SET firstname = '$firstname', lastname ='$lastname', email='$email', floor='$floor', password ='$newPassword', modified = CURRENT_TIME
                WHERE idCaregiver = '$idCaregiver'";
            $insert = $this->db->query($sql);
        } else {
            $sql = "UPDATE a18ux02.Caregiver 
                SET firstname = '$firstname', lastname ='$lastname', email='$email', floor='$floor', modified = CURRENT_TIME
                WHERE idCaregiver = '$idCaregiver'  AND password = '$oldPassword'";
            $insert = $this->db->query($sql);
        }
        //Update user data to users table

        //return the status
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }

    public function getResidents(){
		$sql = "SELECT * FROM a18ux02.Resident";
		$result = $this->db->query($sql)->result();
		return $result;
	}

	public function getQuote($number){
		$sql = "SELECT * FROM a18ux02.Quotes WHERE Quote_ID = ".$number;
		$result = $this->db->query($sql)->result();
        $array = json_decode(json_encode($result), true);
		return $array[0]['Quote'];
	}

	public function getNotes($id){
        $sql = "SELECT * FROM a18ux02.Notes WHERE idCaregiver= ".$id;
        $result = $this->db->query($sql)->result();
        $array = json_decode(json_encode($result), true);
        foreach ($array as $key => $value){
                $this->notes['note'.$key] = array('Note'=>$value['Note'],'noteid'=>$value['idNotes']);
        }
        return $this->notes;
    }

    public function updateNote($notes){
        $cg = $notes['idCaregiver'];
        $n = $notes['note'];
        $idn = $notes['idinput'];
        $sql = "UPDATE a18ux02.Notes 
            SET  Note = '$n' 
            WHERE idCaregiver ='$cg' AND idNotes = '$idn'";
        $this->db->query($sql);
    }
    public function insertNote($notes){
        $cg = $notes['idCaregiver'];
        $n = $notes['note'];
        $sql = "INSERT into a18ux02.Notes (Note, idCaregiver) values ('$n','$cg')";
        $this->db->query($sql);
    }
}
