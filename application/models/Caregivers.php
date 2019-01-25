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
            if(empty($row)) return 2;
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
		$nursingHomeID = $data['nursingHome'];

		$key = $data[key];

		if($this->checkSupervisorKey($nursingHomeID,$key)){
            $sql = "INSERT INTO a18ux02.Caregiver (idCaregiver, firstname, lastname, email, floor, password, hash, created, modified, activated,FK_NursingHome,supervisor,FK_NotificationPref) VALUES (NULL,'$firstname','$lastname','$email','1','$password', '',CURRENT_TIME ,CURRENT_TIME,'0',$nursingHomeID,'1','5')";
        }else{
            $sql = "INSERT INTO a18ux02.Caregiver (idCaregiver, firstname, lastname, email, floor, password, hash, created, modified, activated,FK_NursingHome,FK_NotificationPref) VALUES (NULL,'$firstname','$lastname','$email','1','$password', '',CURRENT_TIME ,CURRENT_TIME,'0',$nursingHomeID,'5')";
        }
        $insert = $this->db->query($sql);
        if($insert){
            return $insert;
        }else{
            return true;
        }
	}

	public function checkKey($nursingHomeID,$key)
	{
		$presql = "SELECT * FROM a18ux02.NursingHome WHERE NursingHome.NursingHomeID =" . $nursingHomeID . " AND NursingHome.key = '$key';";
		$check = json_decode(json_encode($this->db->query($presql)->result(), true));
		if(sizeof($check)> 0){
			return true;
		} else {
			return false;
		}
	}

    public function checkSupervisorKey($nursingHomeID,$key)
    {
        $presql = "SELECT * FROM a18ux02.NursingHome WHERE NursingHome.NursingHomeID =" . $nursingHomeID . " AND NursingHome.supervisorkey = '$key';";
        $check = json_decode(json_encode($this->db->query($presql)->result(), true));
        if(sizeof($check)> 0){
            return true;
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

    public function getCaregivers()
    {
        $sql1 = "SELECT * FROM a18ux02.Caregiver";
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
		$userTbl = $conditions["table"];
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
		if(array_key_exists("order",$conditions)){
		    $sql .= 'ORDER BY ';
		    $sql .= $conditions['orderColumn'];
		    $sql .= ' ';
		    $sql .= $conditions['order'];
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

	public function getQuote($number)
	{
		$sql = "SELECT * FROM a18ux02.Quotes WHERE Quote_ID = " . $number;
		$result = $this->db->query($sql)->result();
		$array = json_decode(json_encode($result), true);
		return $array[0]['Quote'] . "<br>" . "-" . $array[0]['Name'] . "-";
	}

	public function getNotes($id)
	{
		$sql = "SELECT * FROM a18ux02.Notes WHERE idCaregiver= '$id' and idResident IS NULL ORDER BY a18ux02.Notes.idNotes DESC ";
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
	public function sendEmails(){
		$this->caregivers->checkWeekly();
		$this->caregivers->checkMonthly();
	}

	public function checkWeekly(){
		$sendFlag = false;
		$now = new DateTime(date('Y-m-d'));
		$prev_monday = new DateTime(date('Y-m-d', strtotime("previous monday", strtotime($now->format("Y-m-d")))));

		$sql = "SELECT lastEmailSendWeekly FROM a18ux02.GLOBAL WHERE FK_NURSINGHOME = 1";

		$result = json_decode(json_encode($this->db->query($sql)->result()),true);

		$lastEmailSendWeekly_raw = $result[0]['lastEmailSendWeekly'];
		$lastEmailSendWeekly = new DateTime(date("Y-m-d",strtotime($lastEmailSendWeekly_raw)));
//		print_r($lastEmailSendWeekly);
		//chech if today is monday
		if(date('l') == "Monday"){
			//YES: check if we already send emails today:
			if($lastEmailSendWeekly == $now){
				return;
			} else {
				//SEND THOSE EMAILS
				$sendFlag = true;
			}
			//check if lastemailsendweekly is send after the last monday
		} else if($lastEmailSendWeekly > $prev_monday){
			return;
		} else {
			//SEND THOSE EMAILS
			$sendFlag = true;
		}

		if($sendFlag){
			$this->caregivers->sendWeekly();
		}

	}
	public function sendWeekly(){

		//STEP 1: select all the caregivers that are weekly
		$sql = "SELECT * FROM a18ux02.Caregiver
				JOIN a18ux02.NotificationPreferences ON Caregiver.FK_NotificationPref = NotificationPreferences.NotificationPreferencesID
                WHERE NotificationPreferences.Cycle = 'weekly'";

		$result = $this->db->query($sql)->result();
		$array = (json_decode(json_encode($result),true));
		$this->sendWeeklyNots();
		//STEP 2: loop every caregiver
		$caregivers = array();

		foreach($array as $caregiver){

			$this->load->library('email');
			$email = $caregiver['email'];
			$name = $caregiver['firstname'];


			$this->email->set_mailtype('html');
			$this->email->from('a18ux02@gmail.com');
			$this->email->to($email);

			$this->email->subject('weekly updates');

			$message = '<p> Dear ' . $caregiver['firstname'] . ',</p>';
			$message .= '<p>the weekly updates of the resident are here! check them out</p>';
			$message .= '<p> Thanks</p>';

			$this->email->message($message);
//			$this->email->send();

			//UPDATE timestamp
			$sql = "UPDATE a18ux02.GLOBAL SET lastEmailSendWeekly = ".'CURRENT_TIMESTAMP'." WHERE FK_NURSINGHOME = 1;";
//			$this->db->query($sql);
		}

	}
	public function checkMonthly(){
		$sendFlag = false;
		$now = new DateTime(date('Y-m-d'));
		$prev_first = new DateTime(date('Y-m-d', strtotime("first day of this month", strtotime($now->format("Y-m-d")))));
		$sql = "SELECT lastEmailSendWeekly FROM a18ux02.GLOBAL WHERE FK_NURSINGHOME = 1";
		$result = json_decode(json_encode($this->db->query($sql)->result()),true);

		$lastEmailSendWeekly_raw = $result[0]['lastEmailSendWeekly'];
		$lastEmailSendWeekly = new DateTime(date("Y-m-d",strtotime($lastEmailSendWeekly_raw)));
		//chech if today is the first
		if(date('d') == "01"){
			//YES: check if we already send emails today:
			if($lastEmailSendWeekly == $now){
				return;
			} else {
				//SEND THOSE EMAILS
				$sendFlag = true;
			}
			//check if lastemailsendweekly is send after the first
		} else if($lastEmailSendWeekly > $prev_first){
			return;
		} else {
			//SEND THOSE EMAILS
			$sendFlag = true;
		}

		if($sendFlag){
			$this->caregivers->sendMonthly();
		}

	}

	public function sendMonthly(){
//STEP 1: select all the caregivers that are monthly
		$sql = "SELECT * FROM a18ux02.Caregiver
				JOIN a18ux02.NotificationPreferences ON Caregiver.FK_NotificationPref = NotificationPreferences.NotificationPreferencesID
                WHERE NotificationPreferences.Cycle = 'monthly'";


		$result = $this->db->query($sql)->result();
		$array = (json_decode(json_encode($result),true));
		//STEP 2: loop every caregiver
		$caregivers = array();

		foreach($array as $caregiver){
			$this->load->library('email');
			$email = $caregiver['email'];
			$name = $caregiver['firstname'];
			$sql = "SELECT idCaregiver, created FROM a18ux02.Caregiver where email = '$email'";
			$result = $this->db->query($sql);
			$row = $result->row();
			$this->email->set_mailtype('html');
			$this->email->from('a18ux02@gmail.com');
			$this->email->to($email);

			$this->email->subject('monthly updates');

			$message = '<p> Dear ' . $caregiver['firstname'] . ',</p>';
			$message .= '<p>the monthly updates of the resident are here! check them out</p>';
			$message .= '<p> Thanks</p>';

			$this->email->message($message);
//			$this->email->send();

			//UPDATE timestamp
			$sql = "UPDATE a18ux02.GLOBAL SET lastEmailSendMonthly = ".'CURRENT_TIMESTAMP'." WHERE FK_NURSINGHOME = 1;";
//			$this->db->query($sql);
		}

	}

	public function sendWeeklyNots(){
		//get number of floors
		$sql = "SELECT COUNT(*) FROM a18ux02.Floors;";
		$number = json_decode(json_encode($this->db->query($sql)->result()[0]),true)['COUNT(*)'];
		for($i = 1;$i <= $number;$i++){
			//INSERT NOTIFICATION FOR EVERY FLOOR
			$floorsql = "INSERT INTO a18ux02.Notifications (text,FK_FloorID,date) VALUES ('weekly update of Floor ".$i." are available',".$i.",".'CURRENT_TIME'.");";
			$this->db->query($floorsql);
		}
	}

    public function updateNote($notes)
    {
        $cg = $notes['idCaregiver'];
        $n = $notes['note'];
        $idn = $notes['idinput'];

        if(!isset($notes['idResident'])){
            $sql = "INSERT into a18ux02.Notes (idNotes, Note, idCaregiver,created, modified) values ('$idn', '$n','$cg', CURRENT_TIME , CURRENT_TIME )
                  ON DUPLICATE KEY UPDATE Note = '$n', modified = CURRENT_TIME ";
        }else{
            $idRes = $notes['idResident'];
            $sql = "INSERT into a18ux02.Notes (idNotes, Note, idCaregiver,created, modified,idResident) values ('$idn', '$n','$cg', CURRENT_TIME , CURRENT_TIME,'$idRes' )
                ON DUPLICATE KEY UPDATE Note = '$n', modified = CURRENT_TIME ";
        }

        $this->db->query($sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $idNote = $this->db->query($sql);
        return !empty($idNote)?$idNote:false;
    }

    public function deleteNote($notes)
    {
        $id = $notes['idinput'];
        $sql = "DELETE FROM a18ux02.Notes where idNotes = '$id'";
        $this->db->query($sql);
    }

    public function getNotifications(){

		//FIND FLOOR SELECTION ID
		$sql = "SELECT * FROM a18ux02.Caregiver
				RIGHT JOIN a18ux02.NotificationPreferences ON a18ux02.Caregiver.FK_NotificationPref = a18ux02.NotificationPreferences.NotificationPreferencesID
					WHERE a18ux02.Caregiver.idCaregiver = ".$_SESSION['idCaregiver'].";";

		$result = $this->db->query($sql)->result();
		$resultarray = json_decode(json_encode($result),true);
		$floorrow = $resultarray[0]['FK_Floorselect'];

		//FIND FLOOR PREFERENCES
		$sql2 = "SELECT * FROM a18ux02.FloorNotification
				 WHERE FloorNotificationID =".$floorrow.";";
		$result2 = json_decode(json_encode($this->db->query($sql2)->result()),true);

		//FIND NOTIFCATIONID's  THAT CAREGIVER HAS ALREADY SEEN
		$sql = "SELECT FK_Notification FROM a18ux02.Caregiver_notifications WHERE FK_Caregiver =".$_SESSION['idCaregiver'].";";
		$alreadySeenIdsArray = json_decode(json_encode($this->db->query($sql)->result()), true);
		$alreadySeenIds = array();
		foreach ($alreadySeenIdsArray as $item) {
			array_push($alreadySeenIds,$item['FK_Notification']);
		}
		$whereSql = $this->generateWhereForNots($alreadySeenIds);

		//FIND NOTIFICATIONS FOR EACH FLOOR
		$floorNotifications = array();
		$index = 0;
		foreach($result2[0] as $key => $value){
			if($key != 'FloorNotificationID') {
				$index++;
				if ($value == 1) {
					$sql = "SELECT * FROM a18ux02.Notifications WHERE FK_FloorID =" . $index.$whereSql.";";
//					$sql = "SELECT * FROM a18ux02.Notifications WHERE AND FK_FloorID =" . $index;
					$nots = json_decode(json_encode($this->db->query($sql)->result()), true);
					$floorNotifications[$key] = $nots;
				}
			}
		}
		//FIND ID's OF EACH RESIDENT OF EACH FLOOR
		$resIDs_arr = array();
		foreach($result2[0] as $key => $value){
//			echo $value;
			if($key != 'FloorNotificationID') {
				if ($value == 1) {
					$sql = "SELECT residentID FROM a18ux02.Resident WHERE floor =" .substr($key, -1).";";
					$res = json_decode(json_encode($this->db->query($sql)->result()), true);
					array_push($resIDs_arr,$res);
				}
			}
		}
		$resIDs = array();
		foreach ($resIDs_arr as $item) {
			foreach ($item as $car)
			array_push($resIDs,$car['residentID']);
		}

		$orSql = $this->generateWhereForOrs($resIDs);
		//FIND NOTIFICATIONS FOR EACH RESIDENT
		$residentNotifications = array();
		$sql = "SELECT * FROM a18ux02.Notifications WHERE " .$orSql.$whereSql.";";
		$nots = json_decode(json_encode($this->db->query($sql)->result()), true);
//		$residentNotifications[$key] = $nots;
		$notifs = array();
		$notifs['floors'] = $floorNotifications;
		$notifs['residents'] = $nots;
		return $notifs;
	}

	public function generateWhereForNots($alreadySeenIds){
		$sql = '';
			foreach($alreadySeenIds as $key){
				$pre =' AND ';
				$sql .= $pre;
				$sql .="NotificationID"." != '".$key."'";

			}
			return $sql;
	}
	public function generateWhereForOrs($cars){
		$sql = '';
		$i = 0;
			foreach($cars as $key){
				$i++;
				$pre = '(NOT ';
				$sql .= $pre;
				$sql .="FK_ResidentID"." = '".$key."'";
				$sql .= ") ";
				$sql .= ($i<sizeof($cars))?"AND ":"";
			}
			return $sql;
	}

	public function updateNotifSeens($notID){
		$sql = "INSERT INTO a18ux02.Caregiver_notifications (FK_Caregiver,FK_Notification) VALUES (".$_SESSION['idCaregiver'].",".$notID.");";
		$this->db->query($sql);
	}
	public function deleteDuplicates($table){
//		$sql = "DELETE e1 FROM ".$table."e1 INNER JOIN ".$table." e2 WHERE e1.idCaregiver_notifications > e2.idCaregiver_notifications AND e1.FK_Caregiver = e2.FK_Caregiver AND e1.FK_Notification = e2.FK_Notification;";
		$sql = "DELETE e1 FROM a18ux02.Caregiver_notifications e1 INNER JOIN a18ux02.Caregiver_notifications e2 WHERE e1.idCaregiver_notifications > e2.idCaregiver_notifications AND e1.FK_Caregiver = e2.FK_Caregiver AND e1.FK_Notification = e2.FK_Notification;";
//		echo $sql;
//		$this->db->query($sql);
	}
	public function send_validation_email($data){
		$this->load->library('email');
		$email = $data['email'];
		$name = $data['firstname'];

		$sql = "SELECT idCaregiver, created FROM a18ux02.Caregiver where email = '$email'";
		$result = $this->db->query($sql);
		$row = $result->row();
		//print_r($row);
		$email_code = md5((string)$row->created);

		$this->email->set_mailtype('html');
		$this->email->from('a18ux02@gmail.com');
		$this->email->to($email);

		$this->email->subject('Activate your account');

		$message = '<p> Dear ' . $name . ',</p>';
		$message .= '<p><a href="' . base_url() . 'Caregiver/verifyEmail/' . $name . '/' . $email_code . '">Click here</a> to verify your email address.</p>';
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

	public function getNumberOfRows($column){
		$sql = "SELECT MAX(".$column.") FROM a18ux02.Resident";
		$result = $this->db->query($sql);
		return $result;
	}

	public function getIdNoteByText($note){
		$sql = "SELECT idNotes From a18ux02.Notes Where Note = '$note' ORDER BY idNotes DESC limit 1";
		$result = $this->db->query($sql);
		$row = $result->row();
		return $row['idNotes'];
	}

    public function insertQuestion($question, $questionType, $positionNum,$nextQuestionId,$id){
		$sql = "INSERT INTO a18ux02.Question(idQuestion, questionText, questionType, positionNum, nextQuestionId) VALUES ('$id', '$question', '$questionType', '$positionNum', '$nextQuestionId')";
		$this->db->query($sql);

//    	$id_section = $sectionId;
//    	////----caregiver wants to make a new section-----////
//        if(!empty($newSection)){
//        	//push new section in the section table
//            $sql = "INSERT INTO a18ux02.Section(sectionId, sectionType, sectionText, sectionIcon) VALUES (NULL, '$newSection', 'New section', 'extra_questions.png')";
//            $this->db->query($sql);
//			$id_section = $this->db->insert_id();
//            //push new queston with new section
//			$sql2 = "INSERT INTO a18ux02.Question(idQuestion, questionText, questionType, positionNum, nextQuestionId) VALUES (NULL, '$question', '$id_section', 1, NULL)";
//			$this->db->query($sql2);
//        } else {
//        	////----caregiver wants to add a question to a section----////
//
//        	// 1. GET positionNum of last question of the section
//            $sql = "SELECT MAX(positionNum) FROM a18ux02.Question WHERE questionType = '$sectionId'";
//            $max = json_decode(json_encode($this->db->query($sql)->result()),true);
//
//			$prevPos =$max[0]['MAX(positionNum)'];
//			//make variable that is one more => new positionNum
//            $currPos = $prevPos + 1;
//
//			//insert new question with this new positionNum and put nextQuestionID to NULL + get new ID
//            $sql = "INSERT INTO a18ux02.Question(idQuestion, questionText, questionType, positionNum, nextQuestionId) VALUES (NULL, '$question', '$id_section', '$currPos', NULL)";
//            $this->db->query($sql);
//
//			//UPDATE the old last question nextQuestionID to the id you got from the insert
//			$insertedID = $this->db->insert_id();
//            $sql = "UPDATE a18ux02.Question SET nextQuestionId = '$insertedID' WHERE positionNum = '$prevPos' AND questionType = '$sectionId'";
//            $this->db->query($sql);
//		}
    }
     public function getResidentDashboardInfo($conditions = array())
    {
//		echo "init";
        $userTbl = $conditions["table"];
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
        if(array_key_exists("order",$conditions)){
            $sql .= 'ORDER BY ';
            $sql .= $conditions['orderColumn'];
            $sql .= ' ';
            $sql .= $conditions['order'];
        }


        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall();



        return !empty($result)?$result:false;
    }

	function dropQuestionTable(){
		$sql = "DELETE FROM a18ux02.Question";
		$this->db->query($sql);
	}

    public function executeQuery($sql){
        $result = $this->db->query($sql);
        return !empty($result)?$result:false;
    }

    public function deleteCaregiverById($id)
    {
        $sql = "DELETE FROM a18ux02.Caregiver WHERE idCaregiver = '$id'";
        $this->db->query($sql);
    }

    public function deleteResidentById($id)
    {
        $sql = "DELETE FROM a18ux02.Resident WHERE residentID = '$id'";
        $this->db->query($sql);
    }

}
