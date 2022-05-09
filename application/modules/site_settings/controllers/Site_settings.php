<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function _get_website_name() {
        $string = "codeigniter_3.1.10_hmvc";
        return $string;
    }

    function _get_currency_symbol() {
        $string = "$";
        return $string;
    }

    function _get_currency_name() {
        $string = "USD";
        return $string;
	}
	
	function _config_pagination($base_url, $uri_segment) {
        $per_page = 10;
        $config['base_url'] = base_url($base_url);
        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $per_page;
        $config['num_links'] = 1;
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";
        $config['next_link'] = '<i title="Next Page" class="fa fa-angle-double-right"></i>';
        $config['prev_link'] = '<i title="Previous Page" class="fa fa-angle-double-left"></i>';
        $config['first_link'] = '<i title="First page" class="fa fa-step-backward"></i>';
        $config['last_link'] = '<i title="Last page" class="fa fa-step-forward"></i>';

        return $config;

    }
}
