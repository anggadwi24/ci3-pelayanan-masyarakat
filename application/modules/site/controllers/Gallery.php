<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }

    public function index($i) {
       $cek = $this->model_app->view_where('gallery',array('gal_seo'=>$i,'gal_visible'=>'y'));
       if($cek->num_rows () > 0){
           $row = $cek->row_array();
           $data['row'] = $row;
            $data['title'] = $row['gal_title'];
            $this->model_app->update('gallery',array('gal_views'=>$row['gal_views']+1),array('gal_id'=>$row['gal_id']));
            $data['ip'] = $this->input->ip_address();
            $data['js'] = base_url('template/public/js/ajax/gallery/ajax-detail.js');
            $this->template->load('template','mod_gallery/view_detail',$data);
       }else{
           $this->session->set_flashdata('message','Gallery tidak ditemukan');
           redirect('');
       }
           
    }
    function data(){
        if($this->input->method() == 'post'){
            $seo = $this->input->post('seo');
            $output = null;
            $cek = $this->model_app->view_where('gallery',array('gal_seo'=>$seo,'gal_visible'=>'y'));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $content = null;
                $relatedPost =null;
                if($row['gal_status'] == 'photo'){
                    $status = true;
                    $related = $this->model_app->view_where('gallery',array('gal_status'=>'photo','gal_visible'=>'y','gal_id !='=>$row['gal_id'],'gal_category'=>$row['gal_category']));
                    if($related->num_rows() > 0){
                        foreach($related->result_array() as $rel){
                            if($rel['gal_thumbnail'] != NULL){
                                $img = base_url().'upload/berita/'.$rel['gal_thumbnail'];
                            }else{
                                $thumb = $this->model_app->view_where('gallery_photo',array('photo_gal_id'=>$rel['gal_id']))->row_array();
                                if(file_exists('upload/berita/'.$thumb['photo_link'])){
                                   
                                    $img = base_url('upload/berita/'.$thumb['photo_link']);
                                }else{
                                    $img = base_url('upload/berita/default.jpg');
        
                                }
                               
                            }
                           
                            $cat = $this->model_app->view_where('category',array('cat_id'=>$rel['gal_category']))->row_array();
                            $relatedPost .= '<div class="binduz-er-video-post binduz-er-recently-viewed-item">
                            <div class="binduz-er-latest-news-item">
                                <div class="binduz-er-thumb">
                                    <img src="'.$img.'" alt="" style="width:300px;height:200px">
                                </div>
                                <div class="binduz-er-content">
                                    <div class="binduz-er-meta-item">
                                        <div class="binduz-er-meta-categories">
                                            <a href="'.base_url('category/'.$cat['cat_seo']).'">'.ucfirst($cat['cat_category']).'</a>
                                        </div>
                                        <div class="binduz-er-meta-date">
                                            <span><i class="fal fa-calendar-alt"></i>'.tanggal($rel['gal_date']).'</span>
                                        </div>
                                    </div>
                                    <h5 class="binduz-er-title"><a href="'.base_url('gallery/'.$rel['gal_seo']).'">'.limitString($rel['gal_title'],50).'</a></h5>
                                </div>
                            </div>
                        </div>';
                        }
                    }else{
                        $relatedPost = '';
                    }
                    $before = $this->db->query("SELECT * FROM gallery WHERE gal_status = 'photo' AND gal_visible ='y' AND gal_id !='".$row['gal_id']."' AND gal_id < '".$row['gal_id']."' ORDER BY gal_id DESC LIMIT 1 ");
                    $after = $this->db->query("SELECT * FROM gallery WHERE gal_status = 'photo' AND gal_visible ='y' AND gal_id !='".$row['gal_id']."' AND gal_id > '".$row['gal_id']."' ORDER BY gal_id ASC LIMIT 1 ");
                    if($before->num_rows() > 0){
                        $befRow = $before->row_array();
                        $beforeSeo = base_url('gallery/'.$befRow['gal_seo']);
                        $beforeTitle = limitString($befRow['gal_title'],50);
                        $beforePost = '<a href="'.$beforeSeo.'">
                        <span>Prev Post</span>
                            <h4 class="binduz-er-title">'.$beforeTitle.'</h4>
                        </a>';
                    }else{
                        $beforePost = '';
                    }
                    if($after->num_rows() > 0){
                        $afRow = $after->row_array();
                        $afterPost = '<a href="'.base_url('gallery/').$afRow['gal_seo'].'">
                        <span>Prev Post</span>
                        <h4 class="binduz-er-title">'.limitString($afRow['gal_title'],50).'</h4>
                    </a>';
                    }else{
                        $afterPost = '';
                    }
                    $photo = $this->model_app->view_where('gallery_photo',array('photo_gal_id'=>$row['gal_id']));
                    if($photo->num_rows() > 0){
                        $cP = $photo->num_rows();
                        if($cP == 1){
                            $colP = 'col-lg-12';
                        }else if($cP == 2){
                            $colP = 'col-lg-6';
                        }else if($cP == 3){
                            $colP = 'col-lg-4';
                        }else if($cP > 3){
                            $colP = 'col-lg-6';
                        }
                        foreach($photo->result_array() as $pht){
                            if(file_exists('upload/berita/'.$pht['photo_link'])){
                                $foto = base_url().'upload/berita/'.$pht['photo_link'];
                            }else{
                                $foto = base_url('upload/berita/default.jpg');
                            }
                            $content .= "<div class='".$colP."'>
                                            <div class='binduz-er-blog-details-thumb mt-25'>
                                                 <img src='".$foto."' alt=''>
                                            </div>
                                        </div>";
                        }
                    }
                }else if($row['gal_status'] == 'video'){
                    $status = true;
                    $related = $this->model_app->view_where('gallery',array('gal_status'=>'video','gal_visible'=>'y','gal_id !='=>$row['gal_id'],'gal_category'=>$row['gal_category']));
                    if($related->num_rows() > 0){
                        foreach($related->result_array() as $rel){
                            if($rel['gal_thumbnail'] == NULL){
                                $img = base_url('upload/berita/video.jpg');
                            }else{
                                $img = base_url('upload/berita/'.$rel['gal_thumbnail']);
                            }
                            $cat = $this->model_app->view_where('category',array('cat_id'=>$rel['gal_category']))->row_array();
                            $relatedPost .= '<div class="binduz-er-video-post binduz-er-recently-viewed-item">
                            <div class="binduz-er-latest-news-item">
                                <div class="binduz-er-thumb">
                                    <img src="'.$img.'" alt="" style="width:300px;height:200px">
                                </div>
                                <div class="binduz-er-content">
                                    <div class="binduz-er-meta-item">
                                        <div class="binduz-er-meta-categories">
                                            <a href="'.base_url('category/'.$cat['cat_seo']).'">'.ucfirst($cat['cat_category']).'</a>
                                        </div>
                                        <div class="binduz-er-meta-date">
                                            <span><i class="fal fa-calendar-alt"></i>'.tanggal($rel['gal_date']).'</span>
                                        </div>
                                    </div>
                                    <h5 class="binduz-er-title"><a href="'.base_url('gallery/'.$rel['gal_seo']).'">'.limitString($rel['gal_title'],50).'</a></h5>
                                </div>
                            </div>
                        </div>';
                        }
                    }else{
                        $relatedPost = '';
                    }
                    $video = $this->model_app->view_where('gallery_video',array('vid_gal_id'=>$row['gal_id']));
                    $before = $this->db->query("SELECT * FROM gallery WHERE gal_status = 'video' AND gal_visible ='y' AND gal_id !='".$row['gal_id']."' AND gal_id < '".$row['gal_id']."' ORDER BY gal_id DESC LIMIT 1 ");
                    $after = $this->db->query("SELECT * FROM gallery WHERE gal_status = 'video' AND gal_visible ='y' AND gal_id !='".$row['gal_id']."' AND gal_id > '".$row['gal_id']."' ORDER BY gal_id ASC LIMIT 1 ");
                    if($before->num_rows() > 0){
                        $befRow = $before->row_array();
                        $beforeSeo = base_url('gallery/'.$befRow['gal_seo']);
                        $beforeTitle = limitString($befRow['gal_title'],50);
                        $beforePost = '<a href="'.$beforeSeo.'">
                        <span>Prev Post</span>
                            <h4 class="binduz-er-title">'.$beforeTitle.'</h4>
                        </a>';
                    }else{
                        $beforePost = '';
                    }
                    if($after->num_rows() > 0){
                        $afRow = $after->row_array();
                        $afterPost = '<a href="'.base_url('gallery/').$afRow['gal_seo'].'">
                        <span>Prev Post</span>
                        <h4 class="binduz-er-title">'.limitString($afRow['gal_title'],50).'</h4>
                    </a>';
                    }else{
                        $afterPost = '';
                    }
                    if($video->num_rows() > 0){
                        $cV = $video->num_rows();
                        if($cV == 1){
                            $colV = 'col-lg-12';
                        }else if($cV == 2){
                            $colV = 'col-lg-6';
                        }else if($cV == 3){
                            $colV = 'col-lg-4';
                        }else if($cV > 3){
                            $colV = 'col-lg-12';
                        }
                        foreach($video->result_array() as $vid)   {
                            if($vid['vid_embed'] == 'y'){
                                $content .= "<div class='".$colV." my-2'>
                                                <div class='ratio ratio-16x9'>
                                                   ".$vid['vid_embeded']."
                                                </div>
                                            </div>";
                            }else{
                                if(file_exists('upload/berita/').$vid['vid_link']){
                                    $content .= '<div class="'.$colV.' my-2">
                                                    <div class="ratio ratio-16x9">
                                                        <video width="400px" height="300px" controls class="embed-responsive-item">
                                                            <source src="'.base_url('upload/berita/'.$vid['vid_link']).'" type="video/mp4">
                                                         </video>
                                                    </div>
                                            </div>';
                                }
                            }
                        }
                    }

                }else{
                    $this->session->set_flashdata("message",'Gallery tidak ditemukan');
                    $status = false;
                }
                if($status == true){
                    $ip = $this->input->post('ip');
                    $author = $this->model_app->view_where('users',array('users_id'=>$row['gal_created_by']))->row_array();
                    
                    $cat = $this->model_app->view_where('category',array('cat_id'=>$row['gal_category']))->row_array();
                    $output .='<div class="binduz-er-author-item mb-40">
                        
                    <div class="binduz-er-content">
                        <div class="binduz-er-meta-item">
                            <div class="binduz-er-meta-categories">
                                <a href="'.base_url('category/'.$cat['cat_seo']).'">'.ucfirst($cat['cat_category']).'</a>
                            </div>
                            <div class="binduz-er-meta-date">
                                <span><i class="fal fa-calendar-alt"></i>'.tanggal($row['gal_date']).'</span>
                            </div>
                        </div>
                        <h3 class="binduz-er-title">'.$row['gal_title'].'</h3>
                        <div class="binduz-er-meta-author">
                            <div class="binduz-er-author">
                                <img src="'.base_url('upload/users/'.$author['users_photo']).'" style="width:40px;height:40px;" alt="">
                                <span>By <span>'.$author['users_name'].'</span></span>
                            </div>
                            <div class="binduz-er-meta-list">
                                <ul>
                                    <li><i class="fal fa-eye"></i> '.$row['gal_views'].'</li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="binduz-er-blog-details-box">
                        <div class="binduz-er-text">
                           '.$row['gal_desc'].'
                        </div>
                        <div class="row">
                           '.$content.'
                        </div>
                
                     
                        
                      
                        <div class="binduz-er-blog-post-prev-next d-flex justify-content-between align-items-center">
                            <div class="binduz-er-post-prev-next">
                                '.$beforePost.'
                            </div>
                            <div class="binduz-er-post-prev-next text-end">
                               '.$afterPost.'
                            </div>
                            <div class="binduz-er-post-bars">
                                <a href="#"><img src="<?= theme() ?>/images/icon/post-bars.png" alt=""></a>
                            </div>
                        </div>
                        <div class="binduz-er-blog-related-post">
                            <div class="binduz-er-related-post-title">
                                <h3 class="binduz-er-title">Related Post</h3>
                            </div>
                            <div class="binduz-er-blog-related-post-slide">
                                
                                '.$relatedPost.'
                            </div>
                        </div>
                      
                    </div>
                </div>';
                }
            }else{
                $status = false;
                $this->session->set_flashdata("message",'Gallery tidak ditemukan');

            }

            echo json_encode(array('status'=>$status,'output'=>$output));
        }
    }
    function dataMost(){
        if($this->input->method() == 'post'){
            $arr = null;
            

             
                $populer =null;
                $recent = null;
                
                $dataPopuler = $this->db->query("SELECT * FROM berita WHERE berita_publish = 'y' AND berita_visible = 'y' ORDER BY berita_views DESC LIMIT 4");
                $dataRecent = $this->db->query("SELECT * FROM berita WHERE berita_publish = 'y' AND berita_visible = 'y' ORDER BY berita_publish_on ASC LIMIT 4");

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
           
            echo json_encode(array('status'=>$status,'populer'=>$populer,'recent'=>$recent));
        }
    }
}