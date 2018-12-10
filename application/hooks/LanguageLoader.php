<?php
/**
 * Created by PhpStorm.
 * User: Tessa
 * Date: 9/12/2018
 * Time: 14:08
 */

class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');

        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->lang->load('message',$ci->session->userdata('site_lang'));
        } else {
            $ci->lang->load('message','english');
        }
    }
}