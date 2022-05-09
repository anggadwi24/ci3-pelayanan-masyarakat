<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }

    public function index($i) {
       $cek = $this->model_app->view_where('category',array('cat_seo'=>$i,'cat_visible'=>'y'));
       if($cek->num_rows () > 0){
           $row = $cek->row_array();
           $data['row'] = $row;
            $data['title'] = $row['cat_category'];
           
            $data['js'] = base_url('template/public/js/ajax/category/ajax-cat.js');
            $this->template->load('template','mod_category/view_cat',$data);
       }else{
           $this->session->set_flashdata('message','Gallery tidak ditemukan');
           redirect('');
       }
           
    }
    function berita(){
        if($this->input->method() == 'post'){
            $output = null;
            $category = $this->input->post('cat');
            $cek = $this->model_app->view_where('category',array('cat_seo'=>$category));
            if($cek->num_rows() > 0){
                $cat = $cek->row_array();
                $status = true;
                $data = $this->model_app->join_where_order2('berita','berita_category','berita_id','bc_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bc_category'=>$cat['cat_id']),'berita_views','DESC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $gal = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$row['berita_id'],'bgal_main_img'=>'y'))->row_array();
                        if(file_exists('upload/berita/'.$gal['bgal_link'])){
                            $mainImg = base_url().'upload/berita/'.$gal['bgal_link'];
                        }else{
                            $mainImg = base_url().'upload/berita/default.jpg';
                        }
                        $mainCat = null;
                        $catM = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']));
                        if($catM->num_rows() > 0){
                            foreach($catM->result_array() as $ctM){
                                        
                                $mainCat .= "<a href='".base_url('category/'.$ctM['cat_seo'])."' style='margin-right:10px;'>".$ctM['cat_category']."</a>";
                            }
                        }
                        $output .= '<div class="col-xl-3 col-lg-6 col-md-6">
                                <div class="binduz-er-main-posts-item">
                                    <div class="binduz-er-trending-news-list-box">
                                        <div class="binduz-er-thumb">
                                            <img src="'.$mainImg.'" alt="" style="height:200px;">
                                        </div>
                                        <div class="binduz-er-content">
                                            <div class="binduz-er-meta-item">
                                                <div class="binduz-er-meta-categories">
                                                  '.$mainCat.'
                                                </div>
                                                <div class="binduz-er-meta-date">
                                                    <span><i class="fal fa-calendar-alt"></i> '.tanggal($row['berita_publish_on']).'</span>
                                                </div>
                                            </div>
                                            <div class="binduz-er-trending-news-list-title">
                                                <h4 class="binduz-er-title"><a href="'.base_url($row['berita_seo']).'">'.limitString($row['berita_title'],50).'</a></h4>
                                                <p>'.limitString($row['berita_desc'],80).'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                }else{
                   
                    $output = "<div class='col-lg-12'><h6>Tidak ada berita</h6></div>";
                }
            }else{
                $status =false;
            }
            echo json_encode(array('status'=>$status,'output'=>$output));
            

        }
    }
    function foto(){
        if($this->input->method() == 'post'){
            $output = null;
            $category = $this->input->post('cat');
            $cek = $this->model_app->view_where('category',array('cat_seo'=>$category));
            if($cek->num_rows() > 0){
                $cat = $cek->row_array();
                $status = true;
                 $data = $this->model_app->join_where_order2('gallery','gallery_photo','gal_id','photo_gal_id',array('gal_visible'=>'y','gal_category'=>$cat['cat_id']),'gal_views','DESC');
                 if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $catg = $this->model_app->view_where('category',array('cat_id'=>$row['gal_category']))->row_array();
                      
                            
                        $img = base_url('upload/berita/').$row['photo_link'];
                            
                        $output .= '<div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="binduz-er-video-post-item">
                                            <div class="binduz-er-trending-news-list-box">
                                                <div class="binduz-er-thumb">
                                                    <img src="'.$img.'" alt="" style="height:200px">
                                                   
                                                </div>
                                                <div class="binduz-er-content">
                                                    <div class="binduz-er-meta-item">
                                                        <div class="binduz-er-meta-categories">
                                                            <a href="'.base_url('category/'.$catg['cat_seo']).'">'.$catg['cat_category'].'</a>
                                                        </div>
                                                        <div class="binduz-er-meta-date">
                                                            <span><i class="fal fa-calendar-alt"></i> '.tanggal($row['gal_date']).'</span>
                                                        </div>
                                                    </div>
                                                    <div class="binduz-er-trending-news-list-title">
                                                        <h4 class="binduz-er-title"><a href="'.base_url('gallery/'.$row['gal_seo']).'">'.limitString($row['gal_title'],50).'</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                      
                    }
                 }else{
                    $output = "<div class='col-lg-12'><h6>Tidak ada foto</h6></div>";
                 }

            }else{
                $status =false;
            }
            echo json_encode(array('status'=>$status,'output'=>$output));
            

        }
    }
    function video(){
        if($this->input->method() == 'post'){
            $output = null;
            $category = $this->input->post('cat');
            $cek = $this->model_app->view_where('category',array('cat_seo'=>$category));
            if($cek->num_rows() > 0){
                $cat = $cek->row_array();
                $status = true;
                 
                 $data = $this->model_app->join_where_order2('gallery','gallery_video','gal_id','vid_gal_id',array('gal_visible'=>'y','gal_category'=>$cat['cat_id']),'gal_date','DESC');

                 if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $catg = $this->model_app->view_where('category',array('cat_id'=>$row['gal_category']))->row_array();
                      
                            
                        $img = base_url('upload/berita/video.jpg');
                            
                        $output .= '<div class="col-xl-3 col-lg-6 col-md-6">
                                        <div class="binduz-er-video-post-item">
                                            <div class="binduz-er-trending-news-list-box">
                                                <div class="binduz-er-thumb">
                                                    <img src="'.$img.'" alt="" style="height:200px">
                                                   
                                                </div>
                                                <div class="binduz-er-content">
                                                    <div class="binduz-er-meta-item">
                                                        <div class="binduz-er-meta-categories">
                                                            <a href="'.base_url('category/'.$catg['cat_seo']).'">'.$catg['cat_category'].'</a>
                                                        </div>
                                                        <div class="binduz-er-meta-date">
                                                            <span><i class="fal fa-calendar-alt"></i> '.tanggal($row['gal_date']).'</span>
                                                        </div>
                                                    </div>
                                                    <div class="binduz-er-trending-news-list-title">
                                                        <h4 class="binduz-er-title"><a href="'.base_url('gallery/'.$row['gal_seo']).'">'.limitString($row['gal_title'],50).'</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                      
                    }
                 }else{
                    $output = "<div class='col-lg-12'><h6>Tidak ada video</h6></div>";
                 }

            }else{
                $status =false;
            }
            echo json_encode(array('status'=>$status,'output'=>$output));
            

        }
    }
}