<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }

    public function index() {

        $data['title'] = 'Kelurahan Renon';
        
        $data['js'] = '';
        

        
        
        $this->template->load('template','mod_main/view_home',$data);

    }
    function getWeather(){
        if($this->input->method() == 'post'){
            $output = "<a href='#'>". weather('Denpasar')."</a>";
            echo json_encode($output);
        }else{
            $this->output->set_status_header(500);
            $this->load->view('501');
        }
    }
    function dataSlide(){
        if($this->input->method() == 'post'){
            $output = null;
            $data = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_views','DESC',3,0);
            if($data->num_rows() > 0){
                foreach($data->result_array() as $row){
                    if(file_exists('upload/berita/'.$row['bgal_link'])){
                        $img = base_url().'upload/berita/'.$row['bgal_link'];
                    }else{
                        $img = base_url().'upload/berita/default.jpg';
                    }
                    $category = null;
                    $cat = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']));
                    if($cat->num_rows() > 0){
                        foreach($cat->result_array() as $ct){
                                   
                            $category .= "<a href='".base_url('site/category/'.$ct['cat_seo'])."'>".$ct['cat_category']."</a>";
                        }
                    }
                    $user = $this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
                    $output .= '<div class="binduz-er-hero-area d-flex align-items-center">
                                    <div class="binduz-er-bg-cover" style="background-image:url("'.$row['bgal_link'].'")"></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-7">
                                                <div class="binduz-er-hero-news-content">
                                                    <div class="binduz-er-hero-meta">
                                                        <div class="binduz-er-meta-category">
                                                            '.$category.'
                                                        
                                                        </div>
                                                        <div class="binduz-er-meta-date">
                                                            <span><i class="fal fa-calendar-alt"></i> '.tanggal($row['berita_publish_on']).'</span>
                                                        </div>
                                                    </div>
                                                    <div class="binduz-er-hero-title">
                                                        <h3 class="binduz-er-title"><a href="#">'.limitString($row['berita_title'],100).'</a></h3>
                                                    </div>
                                                    <div class="binduz-er-meta-author">
                                                        <div class="binduz-er-author">
                                                            <img src="'.base_url('upload/user/').$user['users_photo'].'" alt="">
                                                            <span>By <span>'.$user['users_name'].'</span></span>
                                                        </div>
                                                        <div class="binduz-er-meta-list">
                                                            <ul>
                                                                <li><i class="fal fa-eye"></i> '.$row['berita_views'].'</li>
                                                               
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="binduz-er-hero-weather d-flex justify-content-end">
                                                    <div class="binduz-er-weather-item">
                                                        <img src="<?= theme() ?>/images/icon/icon-1.png" alt="">
                                                        <h5 class="binduz-er-title">Melbourne</h5>
                                                        <span>31°C / 25 - 32°C</span>
                                                    </div>
                                                    <div class="binduz-er-weather-item">
                                                        <img src="<?= theme() ?>/images/icon/icon-2.png" alt="">
                                                        <h5 class="binduz-er-title">New York </h5>
                                                        <span>31°C / 25 - 32°C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
            }
            echo json_encode($output);
        }else{
            $this->load->view('501');
        }
    }


    

}
