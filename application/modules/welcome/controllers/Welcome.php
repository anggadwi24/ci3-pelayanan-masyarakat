<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    protected $_module = '';
    protected $_logged_user = '';

    function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        
        $this->load->model("welcome_model");
        $this->model = $this->welcome_model;

        // Set the module from the first uri.
        $this->load->module('site_security');
        $this->_module = $this->site_security->_get_module_name();
        // Get The logged User
        $this->_logged_user = $this->site_security->_get_logged_user();
    }

    public function index() {

        $data['page_title'] = "Codeigniter 3.1.10 with HVMC in 2019 by xttrust";
        $data['page_description'] = "Codeigniter 3.1.10 with HVMC in 2019 by xttrust";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "index";

        echo Modules::run('template/public_full', $data);

    }

    
    //public function index()
    //{
        //$this->load->view('welcome_message');

        /* Example of calling methods from other modules
        * echo Modules::run('template/one_col', $data);
        *  OR 
        * $this->load->module('module_name_here');
        * $query = $this->module_name_here->get('id DESC');
        */
    //}
   

    /*
    * Thanks to David Connelley for inspiration.
    * Below i have included some Methods that will hellp you
    * build your websites very easy.
    * USAGE - Call this methods from other views or classes
    *************************************************************
    * $this->load->module('module_name_here');
    * $query = $this->module_name_here->get('id DESC');
    *************************************************************
    */
     
}
