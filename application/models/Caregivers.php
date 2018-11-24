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
		$sql1 = "SELECT * FROM a18ux02.Resident";
		$result = $this->db->query($sql1)->result();
		return $result;
	}

	/*
    * Returns rows from the database based on the conditions
	 * conditons:
	   		- select: which columns you want (string)
			- where: keys and values
			- return_type: 'all','count',single
    * @param string name of the table
    * @param array select, where, order_by, limit and return_type conditions
    */

	public function getRows($conditions = array()){
//		echo "init";
		$userTbl = "a18ux02.Resident";
		$sql = 'SELECT ';
		$sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
		$sql .= ' FROM '.$userTbl;
		if(array_key_exists("where",$conditions)){
			$sql .= ' WHERE ';
			$i = 0;
			foreach($conditions['where'] as $key => $value){
				$pre = ($i > 0)?' AND ':'';
				$sql .= $pre.$key." = '".$value."'";
				$i++;
			}
		}

		$result = $this->db->query($sql);

		$data = array();
		if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
			switch($conditions['return_type']){
				case 'count':
					$data = $result->num_rows;
					break;
				case 'single':
					var_dump($result);
					$data = $result->fetch(PDO::FETCH_ASSOC);
					break;
				default:
					$data = '';
			}
		}else{
			if(count($result->result()) > 0){
				$data = $result;
			}
		}

		return !empty($data)?$data:false;
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

    public function insertNote($notes){
        $cg = $notes['idCaregiver'];
        $n = $notes['note'];
        $sql = "INSERT INTO a18ux02.Notes (idCaregiver, Note) values ('$cg', '$n')";
        $this->db->query($sql);
        return;
    }


}
