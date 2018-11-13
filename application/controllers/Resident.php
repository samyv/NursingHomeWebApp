<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 5-11-2018
 * Time: 18:39
 */

class Resident extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('residents');
        $this->load->library('session');
        $this->load->database('default');
    }

    public function index(){
        $data['page_title'] = 'Login resident | GraceAge';
        $data['residentNames'] = array();
        if($this->session->userdata('isUserLoggedIn')){
            redirect('account');
        }

        if($this->input->post('loginResident')){
            $this->form_validation->set_rules('room_number', 'Room number', 'required');
            if ($this->form_validation->run() == true) {
                $con['conditions'] = array(
                    'room_number'=>$this->input->post('room_number')
                );
                $residentsInRoom = $this->residents->lookUp($con);
                if($residentsInRoom){
                    foreach ($residentsInRoom as $key => $value){
                        $residentArray[$key] = (array) $value;
                    }
                    $data['residentNames'] = $residentArray;
                }else{
                    $data['error_msg'] = 'Wrong room number, please try again';
                }
            }
            else {
                echo "validation false";
            }
        }
        $this->parser->parse('Resident/login', $data);


    }
}