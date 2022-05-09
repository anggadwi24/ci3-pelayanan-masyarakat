<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }

    public function index() {
       
            $data['title'] = 'Kelurahan Renon';
        
            $data['js'] = base_url('template/public/js/ajax/home/ajax-main.js');
        

        
        
            $this->template->load('template','mod_news/view_news',$data);
    }
    function berita($rowno){
        if($this->input->method() == 'post'){
            $rowperpage = 12;

            if($rowno != 0){
                $rowno = ($rowno-1) * $rowperpage;
            }
            $allcount = $this->model_app->join_where_order2('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_publish_on','DESC')->num_rows();
            $data = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_publish_on','DESC',$rowperpage,$rowno);
            $config['base_url'] = base_url().'site/news/index/';
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
                    if(file_exists('upload/berita/'.$row['bgal_link'])){
                        $mainImg = base_url().'upload/berita/'.$row['bgal_link'];
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
                    $no = 1+$no;
                }
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'output'=>$output,'arr'=>$arr));
         

        }
    }
    function detail($news){
        if($news == 'pelayanan'){
            redirect('pelayanan/pengajuan');
        }else{
            $cek = $this->model_app->view_where('berita',array('berita_seo'=>$news,'berita_visible'=>'y'));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                if($row['berita_publish'] == 'y'){
                    $data['title'] = $row['berita_title'];
                    $data['js'] = base_url('template/public/js/ajax/news/ajax-detail.js');
                    $this->template->load('template','mod_news/view_detail',$data);
                }else{
                    $data['title'] = $row['berita_title'];
                    $data['js'] = base_url('template/public/js/ajax/news/ajax-detail1.js');
                    $data['row'] = $cek->row_array();
                    $this->template->load('template','mod_news/view_detail1',$data);
                }
                

            }else{
                $this->session->set_flashdata('message','Berita tidak ditemukan');
                redirect('site/news');
            }
        }
        
    }
    function dataDetail(){
        if($this->input->method() == 'post'){
            $arr = null;
            $data = $this->model_app->view_where('berita',array('berita_seo'=>$this->input->post('berita')));
            if($data->num_rows() > 0){

                $row= $data->row_array();
                $this->viewBerita($row['berita_id']);
                $desc = $row['berita_desc'];
                $title = $row['berita_title'];
                $tanggal = tanggal($row['berita_publish_on']);
                $user = $this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
                $author = ucfirst($user['users_name']);
                $authorImg = base_url('upload/users/').$user['users_photo'];
                $category = null;
                $cat = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']));
                if($cat->num_rows() > 0){
                    foreach($cat->result_array() as $ct){
                               
                        $category .= "<a href='".base_url('category/'.$ct['cat_seo'])."' style='margin-right:10px;'>".$ct['cat_category']."</a>";
                    }
                }
                $view = $row['berita_views'];
                $tag = null;
                $tagz = explode(',',$row['berita_tag']);
                $count = count($tagz);
                for($a=0;$a<$count;$a++){
                    $tag .= '<li style="margin-right:10px;"><a href="#">'.ucfirst($tagz[$a]).'</a></li>';
                }


                $header = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$row['berita_id'],'bgal_main_img'=>'y'))->row_array();
                $imageHeader = base_url('upload/berita/').$header['bgal_link'];
                $body = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$row['berita_id'],'bgal_main_img'=>'n'));
                $imageBody = null;
                if($body->num_rows() > 0){
                    foreach($body->result_array() as $bi){
                        $imageBody .= '<div class=" col-lg-4 col-md-6">
                                            <div class="binduz-er-blog-details-thumb mt-25">
                                                <img src="'.base_url('upload/berita/'.$bi['bgal_link']).'" alt="'.$title.'">
                                            </div>
                                        </div>';
                    }
                }
                $arr = array('title'=>$title,'desc'=>$desc,'date'=>$tanggal,'author'=>$author,'category'=>$category,'view'=>$view,'tag'=>$tag,'imageHeader'=>$imageHeader,'imageBody'=>$imageBody,'authorImg'=>$authorImg);
                $status = true;

            }else{
                $status = false;
                
            }
            echo json_encode(array('status'=>$status,'data'=>$arr));
        }else{
            $this->load->view('501');
        }
    }
    function dataPost(){
        if($this->input->method() == 'post'){
            $arr = null;
            $data = $this->model_app->view_where('berita',array('berita_seo'=>$this->input->post('berita')));
            if($data->num_rows() > 0){

                $row= $data->row_array();
                $before= $this->db->query("SELECT * FROM berita WHERE berita_id < ".$row['berita_id']." AND berita_publish = 'y' AND berita_visible = 'y' ORDER BY berita_id DESC LIMIT 1");
                if($before->num_rows() > 0){
                    $bf = $before->row_array();
                    $beforeName = limitString($bf['berita_title'],30);

                    $beforeUrl = base_url($bf['berita_seo']);
                }else{
                    $beforeName = null;
                    $beforeUrl = null;
                }

                $after= $this->db->query("SELECT * FROM berita WHERE berita_id > ".$row['berita_id']." AND berita_publish = 'y' AND berita_visible = 'y' ORDER BY berita_id ASC LIMIT 1");
                if($after->num_rows() > 0){
                    $af = $after->row_array();
                    $afterName = limitString($af['berita_title'],30);

                    $afterUrl = base_url($af['berita_seo']);
                }else{
                    $afterName = null;
                    $afterUrl = null;
                }
                $status = true;
                $arr = array('beforeName'=>$beforeName,'beforeUrl'=>$beforeUrl,'afterName'=>$afterName,'afterUrl'=>$afterUrl);
            }else{
                $status = false;
            }
            echo json_encode(array('status'=>$status,'data'=>$arr));
        }else{
            $this->load->view('501');
        }
    }
    function dataMost(){
        if($this->input->method() == 'post'){
            $arr = null;
            $data = $this->model_app->view_where('berita',array('berita_seo'=>$this->input->post('berita')));
            if($data->num_rows() > 0){

                $row= $data->row_array();
                $populer =null;
                $recent = null;
                
                $dataPopuler = $this->db->query("SELECT * FROM berita WHERE berita_publish = 'y' AND berita_visible = 'y' AND berita_id != '".$row['berita_id']."' ORDER BY berita_views DESC LIMIT 4");
                $dataRecent = $this->db->query("SELECT * FROM berita WHERE berita_publish = 'y' AND berita_visible = 'y' AND berita_id != '".$row['berita_id']."' ORDER BY berita_publish_on ASC LIMIT 4");

                if($dataPopuler->num_rows() > 0){
                    foreach($dataPopuler->result_array() as $dp){
                        $imgDp = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$dp['berita_id'],'bgal_main_img'=>'y'))->row_array();
                        if(file_exists('upload/berita/'.$imgDp['bgal_link'])){
                            $imgPop = base_url().'upload/berita/'.$imgDp['bgal_link'];
                        }else{
                            $imgPop = base_url().'upload/berita/default.jpg';
                        }
                        $populer .= '<div class="binduz-er-sidebar-latest-post-item">
                                        <div class="binduz-er-thumb">
                                            <img src="'.$imgPop.'" alt="latest" style="width:160px;height:160px;">
                                        </div>
                                        <div class="binduz-er-content">
                                            <span><i class="fal fa-calendar-alt"></i> '.tanggal($dp['berita_publish_on']).'</span>
                                            <h4 class="binduz-er-title"><a href="'.base_url($dp['berita_seo']).'">'.limitString($dp['berita_title'],30).'</a></h4>
                                        </div>
                                    </div>';
                    }
                }

                if($dataRecent->num_rows() > 0){
                    foreach($dataRecent->result_array() as $dr){
                        $imgDr = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$dr['berita_id'],'bgal_main_img'=>'y'))->row_array();
                        if(file_exists('upload/berita/'.$imgDr['bgal_link'])){
                            $imgRec = base_url().'upload/berita/'.$imgDr['bgal_link'];
                        }else{
                            $imgRec = base_url().'upload/berita/default.jpg';
                        }
                        $recent .= '<div class="binduz-er-sidebar-latest-post-item">
                                        <div class="binduz-er-thumb">
                                            <img src="'.$imgRec.'" alt="latest" style="width:160px;height:160px;">
                                        </div>
                                        <div class="binduz-er-content">
                                            <span><i class="fal fa-calendar-alt"></i> '.tanggal($dr['berita_publish_on']).'</span>
                                            <h4 class="binduz-er-title"><a href="'.base_url($dr['berita_seo']).'">'.limitString($dr['berita_title'],30).'</a></h4>
                                        </div>
                                    </div>';
                    }
                }
                $status =true;
            }else{
                $status = false;
                $populer = null;
                $recent = null;
            }
            echo json_encode(array('status'=>$status,'populer'=>$populer,'recent'=>$recent));
        }
    }
    function dataGallery(){
        if($this->input->method() == 'post'){
            $dataVideo = $this->model_app->join_where_order_limit('gallery','gallery_video','gal_id','vid_gal_id',array('gal_visible'=>'y'),'gal_views','DESC',1,0);
            $dataPhoto = $this->model_app->join_where_order_limit('gallery','gallery_photo','gal_id','photo_gal_id',array('gal_visible'=>'y'),'gal_views','DESC',1,0);
            $video = null;
            $photo = null;
            if($dataVideo->num_rows() > 0){
                $rowVideo = $dataVideo->row_array();
                $catVid = $this->model_app->view_where('category',array('cat_id'=>$rowVideo['gal_category']))->row_array();
                $authorVid = $this->model_app->view_where('users',array('users_id'=>$rowVideo['gal_created_by']))->row_array();
                if($rowVideo['gal_thumbnail'] != NULL){
                    $thumb = base_url().'upload/berita/'.$rowVideo['gal_thumbnail'];
                }else{
                    $thumb = base_url('upload/docs/video.jpg');
                }
                $video = '<div class="binduz-er-latest-news-item">
                                    <div class="binduz-er-thumb">
                                        <img src="'. $thumb.'" alt="" style="width:300px;height:200px;">
                                        <div class="binduz-er-play">
                                            <a href="'.base_url('site/gallery/'.$rowVideo['gal_seo']).'"><i class="fas fa-play"></i></a>
                                        </div>
                                    </div>
                                    <div class="binduz-er-content">
                                        <div class="binduz-er-meta-item">
                                            <div class="binduz-er-meta-categories">
                                                <a href="'.base_url('site/category/'.$catVid['cat_seo']).'">'.$catVid['cat_category'].'</a>
                                            </div>
                                            <div class="binduz-er-meta-date">
                                                <span><i class="fal fa-calendar-alt"></i>'.tanggal($rowVideo['gal_date']).'</span>
                                            </div>
                                        </div>
                                        <h5 class="binduz-er-title"><a href="#">'.limitString($rowVideo['gal_title'],50).'</a></h5>
                                        <div class="binduz-er-meta-author">
                                            <span>By <span>'.$authorVid['users_name'].'</span></span>
                                        </div>
                                    </div>
                                </div>
                            ';
            }
            if($dataPhoto->num_rows() > 0){
                $rowPhoto = $dataPhoto->row_array();
                if($rowPhoto['gal_thumbnail'] != NULL){
                    $thumb = base_url().'upload/berita/'.$rowPhoto['gal_thumbnail'];
                }else{
                    $thumb =  base_url('upload/berita/').$rowPhoto['photo_link'];
                }
              
                $catPho = $this->model_app->view_where('category',array('cat_id'=>$rowPhoto['gal_category']))->row_array();
                $authorPho = $this->model_app->view_where('users',array('users_id'=>$rowPhoto['gal_created_by']))->row_array();
                $photo = '<div class="binduz-er-latest-news-item">
                <div class="binduz-er-thumb">
                    <img src="'.$thumb.'" alt="" style="width:300px;height:200px;">
                    
                </div>
                <div class="binduz-er-content">
                    <div class="binduz-er-meta-item">
                        <div class="binduz-er-meta-categories">
                            <a href="'.base_url('site/category/'.$catPho['cat_seo']).'">'.$catPho['cat_category'].'</a>
                        </div>
                        <div class="binduz-er-meta-date">
                            <span><i class="fal fa-calendar-alt"></i>'.tanggal($rowPhoto['gal_date']).'</span>
                        </div>
                    </div>
                    <h5 class="binduz-er-title"><a href="#">'.limitString($rowPhoto['gal_title'],50).'</a></h5>
                    <div class="binduz-er-meta-author">
                        <span>By <span>'.$authorPho['users_name'].'</span></span>
                    </div>
                </div>
            </div>
        ';
            }
        $status = true;
        echo json_encode(array('status'=>$status,'video'=>$video,'photo'=>$photo));
        }else{
            $this->load->view('501');
        }
    }
    private function viewBerita($id){
        $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            if ($this->agent->is_browser())
            {
                    $agent = $this->agent->browser().' '.$this->agent->version().' '.$this->agent->platform(); 
            }
            elseif ($this->agent->is_robot())
            {
                    $agent = $this->agent->robot().' '.$this->agent->platform();
            }
            elseif ($this->agent->is_mobile())
            {
                    $agent = $this->agent->mobile().' '.$this->agent->platform();
            }
            $ip = $this->input->ip_address();
            $cekView = $this->model_app->view_where('berita_views',array('view_berita_id'=>$id,'view_ip_address'=>$ip));
            if($cekView->num_rows() > 0){
                $rowV = $cekView->row_array();
                $hits = $rowV['view_hits']+1;
                $this->model_app->update('berita_views',array('view_hits'=>$hits,'view_user_agent'=>$agent),array('view_id'=>$rowV['view_id']));
            }else{
                $data = array('view_berita_id'=>$id,'view_ip_address'=>$ip,'view_user_agent'=>$agent,'view_hits'=>1);
                $this->model_app->insert('berita_views',$data);
                $view = $row['berita_views']+1;
                $this->model_app->update('berita',array('berita_views'=>$view),array('berita_id'=>$id));
                
            }
        }
    }

    
}