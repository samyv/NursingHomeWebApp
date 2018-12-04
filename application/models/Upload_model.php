<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 4-12-2018
 * Time: 15:46
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    // get image
    public function getPicture() {
        $this->db->select(array('p.id', 'p.url'));
        $this->db->from('picture p');
        $this->db->where('p.id', $this->_ID);
        $query = $this->db->get();
        return $query->row_array();
    }
    // insert image
    public function create($_url) {
        $sql = "INSERT INTO a18ux02.Pictures (pictureURL) VALUES ('$_url')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }
}