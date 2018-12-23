<?php

class languageSwitcher extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    function switchLanguage($language = "") {
        $pn= parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
        redirect($pn, 'refresh');
    }
}
