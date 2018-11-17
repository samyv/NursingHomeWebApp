<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 17-11-2018
 * Time: 10:39
 */

class dropdownmodel extends CI_Model
{
    private $dropdown_menu_items;

    public function __construct()
    {
        parent::__construct();
        // <a href="link" title="title" class="className">name</a>
        $this->dropdown_menu_items = array (
            array('name'=>'Resident overview', 'link'=>'searchRes', 'className'=>'dropdown-item active'),
            array('name'=>'Floor selection', 'link'=>'floorSelect', 'className'=>'dropdown-item inactive'),
            array('name'=>'Floor comparison', 'link'=>'floorCompare', 'className'=>'dropdown-item inactive'),
        );
    }

    function set_active($menutitle) {
        foreach ($this->dropdown_menu_items as &$item) { // reference to $item
            if (strcasecmp($menutitle, $item['link']) == 0) {
                $item['className'] = 'dropdown-item active';
            } else {
                $item['className'] = 'dropdown-item inactive';
            }
        }
    }

    function get_menuItems($menutitle="home") {
        $this->set_active($menutitle);
        return $this->dropdown_menu_items;
    }
}