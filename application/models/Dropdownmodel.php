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
        if($this->session->userdata('supervisor')) {
            $this->dropdown_menu_items = array(
                array('name' => 'Overview Resident', 'link' => 'residents', 'className' => 'dropdown-item active'),
                array('name' => 'Overview Questions', 'link' => 'newQuestion', 'className' => 'dropdown-item inactive'),
                array('name' => 'Selection Floor', 'link' => 'floorSelect', 'className' => 'dropdown-item inactive'),
                array('name' => 'Data Floor', 'link' => 'floorCompare', 'className' => 'dropdown-item inactive'),
                array('name' => 'Add Resident', 'link' => 'newResident', 'className' => 'dropdown-item inactive'),
                array('name' => 'Delete Resident', 'link' => 'deleteResident', 'className' => 'dropdown-item inactive'),
                array('name' => 'Delete Caregiver', 'link' => 'deleteCaregiver', 'className' => 'dropdown-item inactive'),
            );
        }
        else{
            $this->dropdown_menu_items = array(
                array('name' => 'Overview Resident', 'link' => 'residents', 'className' => 'dropdown-item active'),
                array('name' => 'Overview Questions', 'link' => 'newQuestion', 'className' => 'dropdown-item inactive'),
                array('name' => 'Selection Floor', 'link' => 'floorSelect', 'className' => 'dropdown-item inactive'),
                array('name' => 'Data Floor', 'link' => 'floorCompare', 'className' => 'dropdown-item inactive'),
                array('name' => 'Add resident', 'link' => 'newResident', 'className' => 'dropdown-item inactive'),
            );
        }
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