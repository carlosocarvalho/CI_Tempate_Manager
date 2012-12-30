<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('XMLDataManager','','xml');
    }

    public function index() {
        $this->ci_template->set('title','Titulo');
        
        $this->xml->select()->from('menus')->exec();
        $menus['navbar'] =  $this->xml->result_array();
        $navbar =  $this->ci_template->part('base/navbar',$menus);
        $this->ci_template->navbar($navbar);
        $this->ci_template->load('home/index.phtml');
        $this->ci_template->render();
    }

}

