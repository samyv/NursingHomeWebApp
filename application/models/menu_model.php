<?php
/**
 * Created by IntelliJ IDEA.
 * User: Wouter Feremans
 * Date: 19/10/2018
 * Time: 08:18
 */

class Menu_model extends CI_Model {

    private $menu_items;

    public function __construct()
    {
        parent::__construct();
        // <a href="link" title="title" class="className">name</a>
        $this->menu_items = array (
            array('name'=>'Home', 'title'=>'Go home', 'link'=>'home', 'className'=>'active'),
            array('name'=>'Tips', 'title'=>'Look for the tips', 'link'=>'tips', 'className'=>'inactive'),
            array('name'=>'Upcoming events', 'title'=>'Have a look at the upcoming events', 'link'=>'events', 'className'=>'inactive'),
            array('name'=>'Create', 'title'=>'Start a new potluck event', 'link'=>'create', 'className'=>'inactive'),
            array('name'=>'About', 'title'=>'About this website', 'link'=>'about', 'className'=>'inactive'),
        );
    }

    function set_active($menutitle) {
        foreach ($this->menu_items as &$item) { // reference to $item
            if (strcasecmp($menutitle, $item['link']) == 0) {
                $item['className'] = 'active';
            } else {
                $item['className'] = 'inactive';
            }
        }
    }

    function get_menuItems($menutitle="Home") {
        $this->set_active($menutitle);
        return $this->menu_items;
    }
}