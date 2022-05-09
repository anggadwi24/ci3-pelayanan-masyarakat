<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        // __session();
        
      

    }
    function notfound(){
        $this->output->set_status_header('404'); 
        $this->load->view('404');
    }
}