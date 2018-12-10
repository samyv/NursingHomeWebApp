<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 12/10/2018
 * Time: 14:59
 */

class Caregiver extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('caregivers');
		$this->load->model('residents');
		$this->load->library('session');

		$this->load->model('dropdownmodel');
		$this->load->database('default');
		$this->load->helper('security');
		$this->load->model('Upload_model', 'upl');
	}

	/**
     * User account information
     */
	public function account()
	{
		$data = array();
		$userData = array();
		$data['page_title'] = 'Account overview | GraceAge';
		$data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('residents');

		if ($this->session->userdata('success_msg')) {
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if ($this->session->userdata('error_msg')) {
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		if ($this->session->userdata('isUserLoggedIn')) {
			$result = $this->caregivers->getInfo(array('id' => $this->session->userdata('idCaregiver')));
			$data['caregiver'] = $array = json_decode(json_encode($result['0']), True);
			//load the view
			$this->parser->parse('templates/header', $data);
			$this->parser->parse('Caregiver/account', $data);
		} else {
			redirect('index.php');
		}


		if ($this->input->post('saveSettings')) {
			$idCaregiver = $_SESSION['idCaregiver'];
			$this->form_validation->set_rules('firstname', 'First name', 'required');
			$this->form_validation->set_rules('lastname', 'Last name', 'required');
			$this->form_validation->set_rules('floor', 'Floor number', 'required|is_natural_no_zero');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean|trim');
			$this->form_validation->set_rules('old_password', 'old password', 'required|trim|callback_password_check[' . $idCaregiver . ']');
			if (isset($_POST['new_password'])) {
				$this->form_validation->set_rules('new_password', 'new password', 'required|trim');
				$this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[new_password]|trim');
			}

			if ($this->form_validation->run() == true) {
				$userData['firstname'] = strip_tags($this->input->post('firstname'));
				$userData['lastname'] = strip_tags($this->input->post('lastname'));
				$userData['email'] = strip_tags($this->input->post('email'));
				$userData['floor'] = strip_tags($this->input->post('floor'));
				$userData['idCaregiver'] = $idCaregiver;
				$userData['old_password'] = password_hash(trim($this->input->post('old_password')), PASSWORD_BCRYPT, array("cost" => 13));
				if (!empty($_POST['new_password'])) {
					$userData['new_password'] = password_hash(trim($this->input->post('new_password')), PASSWORD_BCRYPT, array("cost" => 13));
				}

				$insert = $this->caregivers->modify($userData);
				if ($insert) {
					$this->session->set_userdata('success_msg', 'Your new settings have been saved');
					redirect('account');
				} else {
					$this->session->set_userdata('error_msg', 'Something went wrong...');
					redirect('account');
				}
			}
		}
		$data['caregiver'] = $userData;
	}

	/**
     * User login
     */
	public function index()
	{
		$data = array();
		$data['page_title'] = 'Login caregiver | GraceAge';
		if ($this->session->userdata('isUserLoggedIn')) {
			redirect('account');
		}

		if ($this->session->userdata('success_msg')) {
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}

		if ($this->session->userdata('error_msg')) {
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		if ($this->input->post('loginSubmit')) {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'required');
			if ($this->form_validation->run() == true) {
				$con['conditions'] = array(
					'email' => trim($this->input->post('email')),
					'password' => password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT, array("cost" => 13))
				);
				$checkLogin = $this->caregivers->lookUp($con);
				if ($checkLogin == 3) {
					$data['error_msg'] = "Please make sure you have activated your account, check your email and spam folder.";
				} elseif ($checkLogin) {
					if (password_verify(trim($this->input->post('password')), $checkLogin['0']->password)) {
						$this->session->set_userdata('isUserLoggedIn', TRUE);
						$this->session->set_userdata('idCaregiver', $checkLogin['0']->idCaregiver);
						$this->session->set_userdata('firstname', $checkLogin['0']->firstname);
						$this->session->set_userdata('lastname', $checkLogin['0']->lastname);
						$this->session->set_userdata('floor', $checkLogin['0']->floor);
						$this->session->set_userdata('email', $checkLogin['0']->email);
						redirect('landingPage');
					} else {
						$data['error_msg'] = 'Wrong email or password, please try again.';
					}
				}
			}
		}


		$this->parser->parse('Caregiver/login', $data);

	}

	/**
     * User registration
     */
	public function register()
	{
		$data = array();
		$userData = array();
		$data['page_title'] = 'Register new caregiver | GraceAge';
		$cond = array();

		$cond["table"] = "a18ux02.NursingHome";
		$result = json_decode(json_encode($this->caregivers->getRows($cond)->result(),true));
		$data['nursingHomes'] = json_decode(json_encode($result),true);

		if ($this->input->post('regisSubmit')) {
//			print_r($this->input->post());
			$key = strip_tags($this->input->post('key'));
			$nursingHomeID = strip_tags($this->input->post('nursingHome'));
			$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|max_length[50]');
			$this->form_validation->set_rules('conf_password', 'confirm password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('key', 'key', 'trim|required|callback_email_check['. strip_tags($this->input->post('nursingHome')) . ']');
			if ($this->form_validation->run() == true) {
				$userData = array(
					'firstname' => strip_tags($this->input->post('firstname')),
					'lastname' => strip_tags($this->input->post('lastname')),
					'email' => strip_tags($this->input->post('email')),
					'password' => password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT, array("cost" => 13)),
					'key' => strip_tags($this->input->post('key')),
					'nursingHome' =>  strip_tags($this->input->post('nursingHome'))
				);
				$insert = $this->caregivers->insert($userData);
				$this->caregivers->send_validation_email($userData);
				if ($insert) {
					$this->session->set_userdata('success_msg', 'Your registration was successfully. Please check your email for the activation link.');
					redirect('index.php');
				} else {
					$data['error_msg'] = 'Some problems occured, please try again.';
				}
			}

		}
		$data['caregiver'] = $userData;
		//load the view
		$this->parser->parse('Caregiver/register', $data);

	}

	/**
     * User logout
     */
    public function logout()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('idCaregiver');
        $this->session->sess_destroy();
        redirect('index.php');
    }

    /**
     * Existing email check during validation
     */
    public function email_check($str)
    {
        $checkEmail = $this->caregivers->lookUpEmail($str);
        if ($checkEmail > 0) {
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * form validation function for the key
     */

    public function key_check($key,$nursingHomeID)
    {
		if ($this->caregivers->checkKey($nursingHomeID,$key)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('email_check', 'Key is incorrect');
			return FALSE;
		}
		return;
    }

    public function password_check($str, $id)
    {

        $con['conditions'] = array('password' => hash('sha256', $str),
            'id' => $id);
        $checkPassword = $this->caregivers->lookUpPassword($con);
        if ($checkPassword) {
            $this->form_validation->set_message('password_check', 'password is incorrect');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function landingPage()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }

        $data = array();
        if ($this->caregivers->getNotes($_SESSION['idCaregiver']) != false) {
            $data['notes'] = $this->caregivers->getNotes($_SESSION['idCaregiver']);
        }

        $dataHeader['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('landingPage');

        $this->parser->parse('templates/header', $dataHeader);
        $this->load->view('Caregiver/landingPage', $data);

    }

    public function searchForResident()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }

        $data = array();
        $data['page_title'] = "Search page";
        $this->load->database('default');
        $data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('residents');
        $this->parser->parse('templates/header', $data);


        // get names out of database
        $result = $this->caregivers->getResidents();
        $data['listCar'] = $result;

        // parse
        $this->parser->parse('Caregiver/searchForResident', $data);
    }

    public function newResident()
    {
        $data = array();
        $data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('newResident');
        $dataResident = array();
        $data['page_title']='Register resident';
        $this->parser->parse('templates/header',$data);

        if($this->input->post('saveSettings')){
            $this->form_validation->set_rules('firstname', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('lastname', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('birthdate','Date','trim|required|callback_date_valid|xss_clean');
            $this->form_validation->set_rules('floor', 'Number', 'trim|required|required|is_natural|xss_clean');
            $this->form_validation->set_rules('room', 'Number', 'trim|required|is_natural_no_zero|xss_clean');
            $this->form_validation->set_rules('cp_first_name', 'Contact First Name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('cp_last_name', 'Contact Last Name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('cp_email', 'Contact Email', 'valid_email|required|trim|xss_clean|callback_cp_check');
            $this->form_validation->set_rules('cp_phone', 'Contact phone', 'required|callback_regex_check|trim|xss_clean');

            if($this->form_validation->run() == true){
                $dataResident = array(
                    'firstname' => strip_tags($this->input->post('firstname')),
                    'lastname' => strip_tags($this->input->post('lastname')),
                    'birthdate' => strip_tags($this->input->post('birthdate')),
                    'floor' => strip_tags($this->input->post('floor')),
                    'room' => strip_tags($this->input->post('room')),
                    'gender' => (strip_tags($this->input->post('gender'))=='male'?'m':'f'),
                    'cp_first_name' =>strip_tags($this->input->post('cp_first_name')),
                    'cp_last_name' =>strip_tags($this->input->post('cp_last_name')),
                    'cp_email' =>strip_tags($this->input->post('cp_email')),
                    'cp_phone' =>strip_tags($this->input->post('cp_phone')),
                );
                // Define file rules

                $config['upload_path']          = './upload/';
                $config['allowed_types']        = 'jpg|jpeg';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload',$config);
                $imagename = 'no-img.jpg';
                if (!$this->upload->do_upload('imageURL')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $this->upload->display_errors();
                } else {
                    $data = $this->upload->data();
                    $dataResident['filepath'] = $data['full_path'];
                    $dataResident['mime'] = $data['file_type'];
                    if($this->residents->insert($dataResident)) {
                        unlink($data['full_path']);
                        $data['success_msg'] = "The new resident is registered successful.";
                        unset($_POST);
                    }else
                    {
                        $data['error_msg'] = "Something went wrong, please try again.";
                    }
                }
            }
        }
        $data['resident'] = $dataResident;
        //load the view
        $this->parser->parse('Caregiver/newResident', $data);
    }

    /*
     * Validate dd/mm/yyyy
     */
    public function date_valid($date)
    {
        $parts = explode("/", $date);
        if (count($parts) == 3) {
            if (checkdate($parts[1], $parts[0], $parts[2]) == false) {
                $this->form_validation->set_message('date_valid', 'The Date field must be mm/dd/yyyy');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    public function notificationView(){
        $data = array();
		$data['floorNotifications'] = $this->caregivers->getNotifications();
//		print_r($data['floorNotifications']);
        $this->parser->parse('templates/header',$data);
        $this->parser->parse('Caregiver/notificationView', $data);

    }

    public function buildingView(){
		if(!$this->session->userdata('isUserLoggedIn')){
			redirect('index.php');
		}
        $data = array();
        $this->load->database('default');
        $result = $this->caregivers->getResidents();
        $data['listCar'] = $result;
        $this->parser->parse('Caregiver/buildingView', $data);
    }

	public function floorView(){
        if(!$this->session->userdata('isUserLoggedIn')){
            redirect('index.php');
        }
		$data = array();
		$cond['where'] = array('floor'	 => $_GET['id']);
		$_SESSION['floorSelected'] = $_GET['id'];
		$cond['table'] = 'a18ux02.Resident';
		$result = json_decode(json_encode($this->caregivers->getRows($cond)->result(),true));
		$data['residents'] = json_decode(json_encode($result),true);
		$data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('floorSelect');
		$this->parser->parse('templates/header',$data);
		$this->parser->parse('Caregiver/floorView', $data);
	}

    public function resDash()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }
        $idResident = $_GET['id'];
        $data = array();
        $cond = array();
		$cond['table'] = "a18ux02.Resident LEFT JOIN a18ux02.Pictures ON a18ux02.Resident.pictureId = a18ux02.Pictures.pictureID";
        $cond['where'] = array('Resident.residentID' => $_GET['id']);
        $row = $this->caregivers->getResidentDashboardInfo($cond);
        $data['resident'] = $row[0];

        if ($this->caregivers->getNotes($_GET['id']) != false) {
            $data['notes'] = $this->caregivers->getNotes($_GET['id']);
        }

        $cond['table'] = "a18ux02.ContactPerson";
        $cond['where'] = array('idContactInformation' => $row[0]['FK_ContactPerson'] );
        $row = $this->caregivers->getRows($cond);
        $result = json_decode(json_encode($row), true);
        $data['contactperson'] = $result['result_object'][0];

        /*
         * change contact info
         */
        $dataContactperson = array();
        if($this->input->post('saveInfo')) {
            $this->form_validation->set_rules('firstname', 'Contact First Name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('lastname', 'Contact Last Name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email', 'Contact Email', 'valid_email|required|trim|xss_clean|callback_cp_check');
            $this->form_validation->set_rules('phonenumber', 'Contact phone', 'required|callback_regex_check|trim|xss_clean');

            if ($this->form_validation->run() == true) {
                $dataContactperson = array(
                    'firstname' => strip_tags($this->input->post('firstname')),
                    'lastname' => strip_tags($this->input->post('lastname')),
                    'email' => strip_tags($this->input->post('email')),
                    'phonenumber' => strip_tags($this->input->post('phonenumber')),
                );
            }
            print_r($dataContactperson);
            $this->residents->updateContactPerson($dataContactperson);
        }


        /*
         * get all the questionnaires from the current Resident
         */

        $cond['table'] = "a18ux02.Questionnaires";
        $cond['where'] = array('Resident_residentID'=> $_GET['id'],
                                'completed' => 1,
                                );
        $cond['order'] = "DESC";
        $cond['orderColumn'] = "timestamp";
        if($row = $this->caregivers->getRows($cond)){
            $result = $row->result();
            $result = json_decode(json_encode($result), true);
            $data['questionnaires'] = $result;
        }

        $data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('resident_dashboard');
        $this->parser->parse('templates/header',$data);

        $this->parser->parse('Caregiver/Resident_Dashboard_template', $data);

    }

    public function floorSelect()
    {
		if(!$this->session->userdata('isUserLoggedIn')){
			redirect('index.php');
		}
		$maxfloors = json_decode(json_encode($this->caregivers->getNumberOfRows('floor')->result()),true);
		$data['maxFloors'] = $maxfloors[0]['MAX(floor)'];

		$data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('floorSelect');
		$this->parser->parse('templates/header',$data);
		$this->parser->parse('Caregiver/buildingView', $data);

	}

    public function roomSelect()
    {
        $data = array();

        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }

        $this->parser->parse('templates/floorView', $data);


	}

    public function residentSelect()
    {
        if (!$this->session->userdata('isUserLoggedIn')) {
            redirect('index.php');
        }

	}

    public function floorCompare()
    {
        $data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('floorCompare');



        $query="select sectionType from a18ux02.Section";
        if($row = $this->caregivers->executeQuery($query)){
            $result=json_decode(json_encode($row->result()),true);
            $data['categories']=$result;
        }


        $maxfloors = json_decode(json_encode($this->caregivers->getNumberOfRows('floor')->result()),true);
        $data['maxFloors'] = $maxfloors[0]['MAX(floor)'];

        $this->parser->parse('templates/header',$data);
        $this->parser->parse('Caregiver/floor_comparison', $data);
    }

    public function saveNote()
    {
        $note = array(
            'note' => $_POST['note'],
            'idinput' => $_POST['idinput'],
            'idCaregiver' => $_SESSION['idCaregiver']
        );
        if(isset($_POST['idResident'])) $note['idResident'] = $_POST['idResident'];
        $idNote = $this->caregivers->updateNote($note);
        return $idNote;
    }

    public function getIdLastNote($note){
        $idNote = $this->caregivers->getIdNoteByText($note);
        return $idNote;
    }

    public function deleteNote()
    {
        $note = array(
            'idinput' => $_POST['idNote'],
            'idCaregiver' => $_SESSION['idCaregiver']
        );
        $this->caregivers->deleteNote($note);
    }

    function verifyEmail($email_address, $email_code)
    {
        $sql = "UPDATE a18ux02.Caregiver
        SET activated = 1 
        WHERE firstname = '$email_address' and MD5(created) = '$email_code'";
        $this->db->query($sql);
        $result = $this->db->affected_rows();

        if ($result > 0) {
            $this->load->view('caregiver/activated');
        } else {
            $this->load->view('caregiver/not_activated');
        }
    }

    function createPasswordMail()
    {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $email = trim($this->input->post('email'));
            $userInfo = $this->caregivers->lookUpByEmail($email);
            $this->load->helper('string');
            $data['email'] = $email;
            $data['activation_id'] = random_string('alnum', 15);
            if (!empty($userInfo)) {
                $row = $userInfo->row();
                $data["firstname"] = (string)$row->firstname;
            }
            $this->caregivers->sendPasswordMail($data);
        }

    }


    // This function used to reset the password
    function resetPassword($email, $activation_id)
    {
        $email = urldecode($email);
        // Check activation id in database
        $is_correct = $this->caregivers->checkActivationDetails($email, $activation_id);
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;

        if ($is_correct == 1) {

            $this->load->view('Caregiver/newPassword', $data);
        } else {
            redirect('index.php');
        }

        if ($this->input->post('resetPassword')) {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|max_length[50]');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'trim|required|matches[password]');
        }

        if ($this->form_validation->run() == true) {
            $data['pw'] = password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT, array("cost" => 13));
            $result = $this->caregivers->updatePassword($data);

            if ($result) {
                $this->session->set_userdata('success_msg', 'Your password has been reset.');
                redirect('index.php');
            }
        }
    }

    public function newQuestion(){
        $data = array();
        $data['dropdown_menu_items'] = $this->dropdownmodel->get_menuItems('newQuestion');
        $data['page_title']='New Question';

        $cond = array();
        $cond['table'] = "a18ux02.Section";
        $row = $this->caregivers->getRows($cond)->result();
        $result = json_decode(json_encode($row), true);
        $data['sections'] = $result;

        if($this->input->post('questionSubmit')){
            //$this->form_validation->set_rules('section_input', 'Section', 'required');
            $this->form_validation->set_rules('question', 'Question', 'required');

            if($this->form_validation->run() == true){

                    $newSection = strip_tags($this->input->post('section_input'));
                    $question = strip_tags($this->input->post('question'));
                    $sectionId = strip_tags($this->input->post('section'));

                $this->caregivers->insertQuestion($question, $newSection, $sectionId);
            }

        }

        $this->parser->parse('templates/header',$data);
        $this->parser->parse('Caregiver/newQuestion', $data);
    }

    /*
     * This function checks if a phone number is in the correct format
     */
    public function regex_check($str)
    {
        if (preg_match('/^((\+|00)32\s?|0)4(60|[789]\d)((\s?\d{2}){3})|((\s?\d{3}){2})/', trim($str))||preg_match('/^((\+|00)32\s?|0)(\d\s?\d{3}|\d{2}\s?\d{2})(\s?\d{2}){2}$/', trim($str)))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('regex_check', 'The %s field is not in the right format');
            return FALSE;
        }
    }

    public function cp_check($str){
        $checkEmail = $this->residents->lookUpEmail($str);
        if ($checkEmail > 0) {
            $this->form_validation->set_message('cp_check', 'There is already a contact person with that email, please select it from the list.');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function getResidentImage(){
        $cond = array();
        $cond['select'] = 'picture';
        $cond['table'] = "a18ux02.Resident LEFT JOIN a18ux02.Pictures ON a18ux02.Resident.pictureId = a18ux02.Pictures.pictureID";
        $cond['where'] = array('Resident.residentID' => $_GET['id']);
        $row = $this->caregivers->getResidentDashboardInfo($cond);
        print_r(base64_encode($row[0]['picture']));
        return base64_encode($row[0]['picture']);
    }

    public function getQuestionnaireResults(){
        $condit['table'] = "a18ux02.Answers INNER JOIN a18ux02.Question ON a18ux02.Answers.questionId = a18ux02.Question.idQuestion";
        $condit['where'] = array('questionnairesId' => $_GET['idQuestionnaire']);
        $condit['select'] = "answer, questionType, positionNum, questionText";
        $condit['order'] = "ASC";
        $condit['orderColumn'] = "questionType, positionNum";
        if ($row = $this->caregivers->getRows($condit)) {
            $result = $row->result();
            $result = json_encode($result);
            print_r($result);
            return $result;
        }
    }

    public function getFloorData(){
        $query = "SELECT a18ux02.Resident.floor, a18ux02.Question.questionType, a18ux02.Questionnaires.timestamp, AVG(a18ux02.Answers.answer) as answers  
                    from a18ux02.Questionnaires 
                    INNER JOIN a18ux02.Answers 
                        on a18ux02.Questionnaires.idQuestionnaires = a18ux02.Answers.questionnairesId
                    INNER JOIN a18ux02.Resident
                        on a18ux02.Questionnaires.Resident_residentID = a18ux02.Resident.residentID
                    INNER JOIN a18ux02.Question
                        on a18ux02.Answers.questionId = a18ux02.Question.idQuestion
                    where  a18ux02.Questionnaires.Completed = '1'
                    GROUP BY a18ux02.Questionnaires.timestamp, a18ux02.Question.questionType, a18ux02.Resident.floor 
                    ORDER BY a18ux02.Resident.floor, a18ux02.Questionnaires.timestamp, a18ux02.Question.questionType ASC";
        if($row = $this->caregivers->executeQuery($query)){
            $result = $row->result();
            $result = json_decode(json_encode($result),true);
            $query = "select MAX(a18ux02.Question.questionType) as 'max' FROM a18ux02.Question";
            if($row2 = $this->caregivers->executeQuery($query))
            {
                $result2 = json_decode(json_encode($row2->result()),true);
                $max = $result2[0]['max'];
                $result = json_encode(array($result,$max));
                print_r($result);
            }


        }
    }
    public function getFloorSpinData(){
        $query = "SELECT AVG(a18ux02.Answers.answer), a18ux02.Resident.floor , a18ux02.Question.questionType
                    from a18ux02.Questionnaires 
                    INNER JOIN a18ux02.Answers 
                        on a18ux02.Questionnaires.idQuestionnaires = a18ux02.Answers.questionnairesId
                    INNER JOIN a18ux02.Resident
                        on a18ux02.Questionnaires.Resident_residentID = a18ux02.Resident.residentID
                    INNER JOIN a18ux02.Question
                        on a18ux02.Answers.questionId = a18ux02.Question.idQuestion
                    GROUP BY a18ux02.Question.questionType, a18ux02.Resident.floor
                    ORDER BY a18ux02.Question.questionType, a18ux02.Resident.floor ASC";
        if($row = $this->caregivers->executeQuery($query)){
            $result = $row->result();
            $result = json_decode(json_encode($result),true);
            $query = "select MAX(a18ux02.Question.questionType) as 'max' FROM a18ux02.Question";
            if($row2 = $this->caregivers->executeQuery($query))
            {
                $result2 = json_decode(json_encode($row2->result()),true);
                $max = $result2[0]['max'];
                $result = json_encode(array($result,$max));
                print_r($result);
            }
        }
    }
}
