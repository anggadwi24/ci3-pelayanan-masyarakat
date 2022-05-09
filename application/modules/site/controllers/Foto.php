<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }

    public function index() {
       
            $data['title'] = 'Kelurahan Renon';
        
            $data['js'] = base_url('template/public/js/ajax/gallery/ajax-foto.js');
        

        
        
            $this->template->load('template','mod_gallery/view_foto',$data);
    }
    function data($rowno){
        if($this->input->method() == 'post'){
            $rowperpage = 12;

            if($rowno != 0){
                $rowno = ($rowno-1) * $rowperpage;
            }
            $allcount = $this->model_app->join_where_order2('gallery','gallery_photo','gal_id','photo_gal_id',array('gal_visible'=>'y'),'gal_date','DESC')->num_rows();
            $data = $this->model_app->join_where_order_limit('gallery','gallery_photo','gal_id','photo_gal_id',array('gal_visible'=>'y'),'gal_date','DESC',$rowperpage,$rowno);
            $config['base_url'] = base_url().'site/foto/index/';
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $allcount;
            $config['per_page'] = $rowperpage;
        
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $this->pagination->initialize($config);
                            
            // Initialize $data Array
            $arr['pagination'] = $this->pagination->create_links();
            $status = true;
            $page = $this->input->post('pagno');
            if($page == 0){
                $page = 1;
            }else{
                $page = $page;
            }
            $arr['row'] = $page;
            $msg = null;
            $output = null;
            if($data->num_rows() > 0){  
                $no =$rowno+1;
                foreach($data->result_array() as $row){
                    $catg = $this->model_app->view_where('category',array('cat_id'=>$row['gal_category']))->row_array();
                  
                        
                    if($row['gal_thumbnail'] != NULL){
                        $img = base_url().'upload/berita/'.$row['gal_thumbnail'];
                    }else{
                        if(file_exists('upload/berita/'.$row['photo_link'])){
                           
                            $img = base_url('upload/berita/'.$row['photo_link']);
                        }else{
                            $img = base_url('upload/berita/default.jpg');

                        }
                       
                    }
                        
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
                    $no = 1+$no;
                }
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'output'=>$output,'arr'=>$arr));
         

        }
    }
}