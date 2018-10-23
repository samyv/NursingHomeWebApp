<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 12-10-2018
 * Time: 15:48
 */

class Event_model extends CI_Model{
    public function get_events(){
        $this->db->order_by("date","desc");
        $query = $this->db->get("events"); //tablename = events, this does SELECT*
        return $query->result();
    }
}