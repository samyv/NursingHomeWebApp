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

    function lookUp($params = array())
    {
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
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
    public function insert($data = array())
    {
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
        $mime = $data['mime'];

        $blob = fopen($data['filepath'], 'rb');


        // insert contact person in DB


        $sql = "INSERT INTO a18ux02.Pictures (pictureMime, picture) VALUES ('$mime', :data)";
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);
        $stmt->execute();
        $pictureid = $this->db->insert_id();

        $sql = "INSERT INTO a18ux02.ContactPerson (firstname, lastname, email, phonenumber) VALUES ('$cp_first_name','$cp_last_name','$cp_email','$cp_phone')";
        $this->db->query($sql);
        $idcp = $this->db->insert_id();


        //insert resident in resident table
        $sql = "INSERT INTO a18ux02.Resident(residentID, firstname, lastname, birthdate, floor, room, gender,FK_ContactPerson, pictureId) VALUES (NULL, '$firstname','$lastname', '$birthdate', '$floor','$room','$gender','$idcp','$pictureid')";
        $insert = $this->db->query($sql);

        //return the status
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    function lookUpEmail($params)
    {
        $sql = "SELECT * FROM a18ux02.ContactPerson WHERE email = '$params'";
        $result = $this->db->query($sql)->result();
        return count($result);
    }


    public function updateContactPerson($data = array())
    {
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $phonenumber = $data['phonenumber'];

        $sql = "UPDATE a18ux02.ContactPerson 
                    SET firstname = '$firstname', lastname= '$lastname', email = '$email', phonenumber ='$phonenumber'
                    WHERE idContactInformation = 9";
        $this->db->query($sql);

    }

    public function getNotes($id)
    {
        $sql = "SELECT * FROM a18ux02.Notes WHERE idResident= " . $id;
        $result = $this->db->query($sql);
        if (!empty($result)) {
            $array = json_decode(json_encode($result->result()), true);
            foreach ($array as $key => $value) {
                $this->notes['note' . $key] = array('Note' => $value['Note'], 'noteid' => $value['idNotes']);
            }
            return $this->notes;
        } else {
            return false;
        }
    }
}