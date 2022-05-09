<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends MX_Controller {

    protected $model = '';
    protected $_module = '';
    protected $_logged_user = '';

    function __construct() {
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        
        $this->load->model("model_model");
        $this->model = $this->model_model;

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


    // Standard Functions for all controllers.
    function get($order_by = FALSE) {
        if ($order_by != FALSE) {
            $query = $this->model->get($order_by);
        } else {
            $query = $this->model->get();
        }

        return $query;
    }

    function search_query($query) {
        $query = $this->model->search($query);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $query = $this->model->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where_id($id) {
        $query = $this->model->get_where_id($id);
        return $query;
    }
    
    function get_where($col, $value) {
        $query = $this->model->get_where($col, $value);
        return $query;
    }

    function get_where_row($col, $value) {
        $query = $this->model->get_where_row($col, $value);
        return $query;
    }

    function get_where_list($col, $value) {
        $query = $this->model->get_where_list($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->model->_insert($data);
    }

    function _update($id, $data) {
        $this->model->_update($id, $data);
    }

    function _delete($id) {
        $this->model->_delete($id);
    }
    
    function count_all() {
        $count = $this->model->count_all();
        return $count;
    }

    function count_where($column, $value) {
        $count = $this->model->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $max_id = $this->model->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $query = $this->model->_custom_query($mysql_query);
        return $query;
    }

    

}
