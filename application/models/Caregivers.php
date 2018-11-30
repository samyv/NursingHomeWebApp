<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 8-11-2018
 * Time: 16:35
 */

Class Caregivers extends CI_Model
{


    private $notes;

    function __construct()
    {
        $this->load->database('default');
    }

    function getInfo($params = array())
    {
        if (array_key_exists("id", $params)) {
            $id = $params['id'];
            $sql = "Select * from a18ux02.Caregiver where idCaregiver = '$id'";
            $result = $this->db->query($sql)->result();
            return $result;
        }
    }

    function lookUp($params = array())
    {
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            $email = $params['conditions']["email"];
            $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email'";
            $result = $this->db->query($sql);
            $row = $result->row();
            if ((string)$row->activated == 0) return 3;
            else return $result->result();
        }

    }

    function lookUpEmail($params)
    {
        $email = $params;
        $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email'";
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    function lookUpByEmail($params)
    {
        $email = $params;
        $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email'";
        $result = $this->db->query($sql);
        return $result;
    }

    function lookUpPassword($params = array())
    {
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            $password = $params['conditions']["password"];

            $id = $params['conditions']["id"];
            $sql = "SELECT password FROM a18ux02.Caregiver WHERE idCaregiver = '$id'";
            $result = $this->db->query($sql)->result();
            if ($password != $result['0']->password) {
                return true;
            } else {
                return false;
            }

        }
    }

    /*
     * Insert user information
     */
    public function insert($data = array())
    {
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $password = $data['password'];
        //insert user data to users table
        $sql = "INSERT INTO a18ux02.Caregiver (idCaregiver, firstname, lastname, email, floor, password, hash, created, modified, activated) VALUES (NULL,'$firstname','$lastname','$email','1','$password', '',CURRENT_TIME ,CURRENT_TIME,'0')";
        $insert = $this->db->query($sql);

        //return the status
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    public function modify($data = array())
    {
        $idCaregiver = $data['idCaregiver'];
        $firstname = $data['firstname'];
        $floor = $data['floor'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $oldPassword = $data['old_password'];

        if (!empty($data['new_password'])) {
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
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    public function getResidents()
    {
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

    public function getRows($conditions = array())
    {
//		echo "init";
        $userTbl = "a18ux02.Resident";
        $sql = 'SELECT ';
        $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM ' . $userTbl;
        if (array_key_exists("where", $conditions)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where'] as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }


        $result = $this->db->query($sql);

        $data = array();
        if (array_key_exists("return_type", $conditions) && $conditions['return_type'] != 'all') {
            switch ($conditions['return_type']) {
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
        } else {
            if (count($result->result()) > 0) {
                $data = $result;
            }
        }

        return !empty($data) ? $data : false;
    }

    public function getQuote($number)
    {
        $sql = "SELECT * FROM a18ux02.Quotes WHERE Quote_ID = " . $number;
        $result = $this->db->query($sql)->result();
        $array = json_decode(json_encode($result), true);
        return $array[0]['Quote'] . "<br>" . "-" . $array[0]['Name'] . "-";
    }

    public function getNotes($id)
    {
        $sql = "SELECT * FROM a18ux02.Notes WHERE idCaregiver= " . $id;
        $result = $this->db->query($sql)->result();
        if (!empty($result)) {
            $array = json_decode(json_encode($result), true);
            foreach ($array as $key => $value) {
                $this->notes['note' . $key] = array('Note' => $value['Note'], 'noteid' => $value['idNotes']);
            }
            return $this->notes;
        } else {
            return false;
        }
    }

    public function updateNote($notes)
    {
        $cg = $notes['idCaregiver'];
        $n = $notes['note'];
        $idn = $notes['idinput'];
        $sql = "INSERT into a18ux02.Notes (idNotes, Note, idCaregiver,created, modified) values ('$idn', '$n','$cg', CURRENT_TIME , CURRENT_TIME )
                ON DUPLICATE KEY UPDATE Note = '$n', modified = CURRENT_TIME ";
        $this->db->query($sql);
    }

    public function deleteNote($notes)
    {
        $cg = $notes['idCaregiver'];
        $id = $notes['idinput'];
        $sql = "DELETE FROM a18ux02.Notes WHERE idCaregiver = '$cg' AND idNotes = '$id'";
        $this->db->query($sql);
    }

    public function send_validation_email($data)
    {
        $this->load->library('email');
        $email = $data['email'];
        $name = $data['firstname'];

        $sql = "SELECT idCaregiver, created FROM a18ux02.Caregiver where email = '$email'";
        $result = $this->db->query($sql);
        $row = $result->row();
        $email_code = md5((string)$row->created);

        $this->email->set_mailtype('html');
        $this->email->from('a18ux02@gmail.com');
        $this->email->to($email);

        $this->email->subject('Activate your account');

        $message = '<p> Dear ' . $name . ',</p>';
        $message .= '<p><a href="' . base_url() . 'Caregiver/verifyEmail/' . $name . '/' . $email_code . '">click here</a> to verify your email address</p>';
        $message .= '<p> Thanks</p>';

        $this->email->message($message);
        $this->email->send();
    }


    public function sendPasswordMail($data)
    {
        $this->load->library('email');
        $email_coded = urlencode($data['email']);
        $email = $data['email'];
        $name = $data['firstname'];
        $email_code = $data['activation_id'];

        $sql = "UPDATE a18ux02.Caregiver
                    SET hash = '$email_code'
                WHERE email = '$email'";
        $this->db->query($sql);

        $this->email->set_mailtype('html');
        $this->email->from('a18ux02@gmail.com');
        $this->email->to($email);

        $this->email->subject('Reset password');

        $message = '<p> Dear ' . $name . ',</p>';
        $message .= '<p><a href="' . base_url() . 'Caregiver/resetPassword/' . $email_coded . '/' . $email_code . '">click here</a> to reset your password</p>';
        $message .= '<p> Thanks</p>';

        $this->email->message($message);
        $this->email->send();
    }

    public function checkActivationDetails($email, $activation_id)
    {
        $sql = "SELECT * FROM a18ux02.Caregiver WHERE email = '$email' and hash = '$activation_id'";
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function updatePassword($data)
    {
        $email = $data['email'];
        $activation_id = $data['activation_code'];
        $pw = $data['pw'];

        $sql = "UPDATE a18ux02.Caregiver
	    SET password = '$pw', hash = ''
        Where email = '$email' and hash = '$activation_id'";
        $result = $this->db->query($sql);
        return count($result);
    }


}
