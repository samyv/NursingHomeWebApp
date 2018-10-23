<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 12/10/2018
 * Time: 14:59
 */

class Potluckcontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->helper('url');
        //$this->load->model('Menu_model');
    }
    public function home(){
        $data['page_title']='UWE TITEL';
        $data['content']='blablabla';
        $data['content_title_1']='tit1';
        $data['content_title_2']='tit2';
       //$data['menu_items'] = $this->Menu_model->get_menuItems('home');
        $this->parser->parse('potlucktemplate',$data);
    }

    public function about(){
        $people['names'] = array(
            array('name' => 'Vero'),
            array('name' => 'Jeroen'),
            array('name' => 'Koen')
        );
        $data['page_title']='About';
        $data['content']=$this->parser->parse('people',$people,true);
        $data['content_title_1']='tit1';
        $data['content_title_2']='tit2';
       // $data['menu_items'] = $this->Menu_model->get_menuItems('about');
        $this->parser->parse('potlucktemplate',$data);
    }

    public function events($format = "normal"){
        $this->load->model('Event_model');
        $events = $this->Event_model->get_events();
        if($format == "normal") {
            $data['page_title'] = 'UXWD event\'s page';
            $data2['events'] = $events;
            $data['content'] = $this->parser->parse('events', $data2, true);
       //     $data['menu_items'] = $this->Menu_model->get_menuItems('events');
            $this->parser->parse('potlucktemplate', $data);
        }
        elseif($format =="html") {
            $data2['events'] = $events;
            $result = $this->parser->parse('events' ,$data2, true);
            $this->output->set_content_type('text/html')->append_output($result);
        }
        elseif($format == "json"){
            $data2['events']= $events;
            $this->output->set_content_type('application/json')->append_output(json_encode($events));
        }
    }


}