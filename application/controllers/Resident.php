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
    }

    public function index(){
        $data['page_title'] = 'Login resident | GraceAge';
        $this->parser->parse('Rlogin', $data);
    }
}