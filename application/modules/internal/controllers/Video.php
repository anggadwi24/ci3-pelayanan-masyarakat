<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/video');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Video';
        $data['header'] = 'Video';

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/video').'">Video</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_where_ordering('gallery',array('gal_visible'=>'y','gal_status'=>'video'),'gal_id','DESC');
        $this->template->load('template','mod_gallery/view_video',$data);
    }
    function add(){
        __ceksess('internal/video/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Video';
        $data['header'] = 'Tambah Video';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/video').'">Video</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template_upload','mod_gallery/view_video_add',$data);

      
    }
    function edit(){
        __ceksess('internal/video/edit');

        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('gallery',array('gal_id'=>$id,'gal_status'=>'video','gal_visible'=>'y'));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Video';
                $data['header'] = 'Edit Video';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/video').'">Video</a></li>';

                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
        
                $data['js'] = '';
                $this->template->load('template_upload','mod_gallery/view_video_edit',$data);
            }else{
                $this->session->set_flashdata('message','Gallery Tidak ditemukan!');
                redirect('internal/video');
            }
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function test(){
        $arr = 'https://youtu.be/yjsf4Z5I5CQ';
        echo lastExplode('/',$arr);
    }
    function storeVideo(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('galid'));
           
            $cek = $this->model_app->view_where('gallery',array('gal_id'=>$id));
            if($cek->num_rows() > 0 ){
                $embed = $this->input->post('embed');
                $row = $cek->row_array();
                $title = $row['gal_title'];
                $date = date('Y-m-d H:i:s');
                $created_by = decode($this->session->userdata['internal']['id']);
                if($embed == 'y'){
                   

                    $string = $this->input->post('link');
                    $linkB = lastExplode('/',$string);
                    $link = $string;
                    $embed = 'https://www.youtube.com/embed/'.$linkB;
                    
                    $embeded = '<iframe  width="560" height="315" src="'.$embed.'" title="'.$title.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    $dataV = array('vid_gal_id'=>$id,'vid_embed'=>'y','vid_link'=>$link,'vid_date'=>$date,'vid_update_by'=>$created_by,'vid_embeded'=>$embeded);
                    $this->model_app->insert('gallery_video',$dataV);
                    $this->session->set_flashdata('success','Video Berhasil Disimpan');
                    redirect('internal/video/edit?id='.encode($id));
                }else{
                    $config['upload_path']          = './upload/berita/';
                    $config['encrypt_name'] = TRUE;
                    $config['allowed_types'] = 'mp4|mkv|avi'; # 
                    $config['max_size']             = 100000;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('files')){
                        $upload_data = $this->upload->data();
                        $foto = $upload_data['file_name'];
                      
                        $dataV = array('vid_gal_id'=>$id,'vid_embed'=>'n','vid_link'=>$foto,'vid_date'=>$date,'vid_update_by'=>$created_by);
                        $this->model_app->insert('gallery_video',$dataV);
                        
                        
                        $this->session->set_flashdata('success','Video Berhasil Disimpan');
                        redirect('internal/video/edit?id='.encode($id));
                    
                    
                    }else{
                        $msg = replace( array('<p>','</p>'),$this->upload->display_errors());
                        $this->session->set_flashdata('message',$msg);
                        redirect('internal/video/edit?id='.encode($id));
                    }
                }
            }else{
                $this->session->set_flashdata('message','Gallery tidak ditemukan!');
                redirect('internal/video');
            }
           
        }else{
            $this->load->view('501');
        }
    }
    function store(){
        if($this->input->method() == 'post' || $this->input->post('title') != null){
            $embed = $this->input->post('embed');
            $config1['upload_path']          = './upload/berita/';
            $config1['encrypt_name'] = TRUE;
            $config1['allowed_types']        = 'gif|jpg|png|jpeg';
            $config1['max_size']             = 3000;
                
            $this->load->library('upload', $config1,'main');
                    
            // $this->load->library('upload', $config);
            if ($this->main->do_upload('file')){
                if($embed == 'y'){
                    $content = $this->input->post('content');
                    $title = $this->input->post('title');
                    $upload_data = $this->main->data();
                    $thumbnail = $upload_data['file_name'];
                    $created_by = decode($this->session->userdata['internal']['id']);
                    $date = date('Y-m-d H:i:s');
                    $seo = seo($title);
                    $data = array(
                        'gal_title'=>$title,
                        'gal_seo'=>$seo,
                        'gal_desc'=>$content,
                        'gal_created_by'=>$created_by,
                        'gal_category'=>$this->input->post('kategori'),
                        'gal_date'=>$date,
                        'gal_status'=>'video',
                        'gal_thumbnail'=>$thumbnail,
                        'gal_views'=>0,
                        
        
                        'gal_visible'=>'y'
                    );
                    $string = $this->input->post('link');
                    $linkB = lastExplode('/',$string);
                    $link = $string;
                    $embed = 'https://www.youtube.com/embed/'.$linkB;
                    $gal_id = $this->model_app->insert_id('gallery',$data);
                    $embeded = '<iframe width="560" height="315" src="'.$embed.'" title="'.$title.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    $dataV = array('vid_gal_id'=>$gal_id,'vid_embed'=>'y','vid_link'=>$link,'vid_date'=>$date,'vid_update_by'=>$created_by,'vid_embeded'=>$embeded);
                    $this->model_app->insert('gallery_video',$dataV);
                    
                    
                    $this->session->set_flashdata('success','Data Berhasil Disimpan');
                    redirect('internal/video');
                }else{
                    $config['upload_path']          = './upload/berita/';
                    $config['encrypt_name'] = TRUE;
                    $config['allowed_types'] = 'mp4|mkv|avi'; # 
                    $config['max_size']             = 100000;
                        
                    $cat = $this->input->post('cat');
                    $seo = seo($cat);
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('files')){
                        $upload_data = $this->upload->data();
                        $foto = $upload_data['file_name'];
                        $content = $this->input->post('content');
                        $title = $this->input->post('title');
                        $created_by = decode($this->session->userdata['internal']['id']);
                        $date = date('Y-m-d H:i:s');
                        $seo = seo($title);
                        $data = array(
                            'gal_title'=>$title,
                            'gal_seo'=>$seo,
                            'gal_desc'=>$content,
                            'gal_created_by'=>$created_by,
                            'gal_category'=>$this->input->post('kategori'),
                            'gal_date'=>$date,
                            'gal_status'=>'video',
                            'gal_views'=>0,
                            
            
                            'gal_visible'=>'y'
                        );
            
                        $gal_id = $this->model_app->insert_id('gallery',$data);
                        $dataV = array('vid_gal_id'=>$gal_id,'vid_embed'=>'n','vid_link'=>$foto,'vid_date'=>$date,'vid_update_by'=>$created_by);
                        $this->model_app->insert('gallery_video',$dataV);
                        
                        
                        $this->session->set_flashdata('success','Data Berhasil Disimpan');
                        redirect('internal/video');
                    
                    
                    }else{
                        $msg = replace( array('<p>','</p>'),$this->upload->display_errors());
                        $this->session->set_flashdata('message',$msg);
                        redirect('internal/video/add');
                    }
                }
            }else{
                
                $this->session->set_flashdata('message',$this->main->display_errors());
                redirect('internal/video/add');
            }
        
          
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post'  ){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('gallery',array('gal_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $config1['upload_path']          = './upload/berita/';
                $config1['encrypt_name'] = TRUE;
                $config1['allowed_types']        = 'gif|jpg|png|jpeg';
                $config1['max_size']             = 3000;
                    
                $this->load->library('upload', $config1,'main');
                        
                // $this->load->library('upload', $config);
                if ($this->main->do_upload('file')){
                    $path = './upload/berita/'.$row['gal_thumbnail'] ;
           
          
                    unlink($path);
                    $upload_data = $this->main->data();
                    $thumbnail = $upload_data['file_name'];
                }else{  
                    $thumbnail = $row['gal_thumbnail'];
                }
                $content = $this->input->post('content');
                $title = $this->input->post('title');
                $created_by = decode($this->session->userdata['internal']['id']);
                $date = date('Y-m-d H:i:s');
                $seo = seo($title);
                $data = array(
                      'gal_title'=>$title,
                      'gal_seo'=>$seo,
                      'gal_desc'=>$content,
                      'gal_thumbnail'=>$thumbnail,
                      'gal_category'=>$this->input->post('kategori'),
                   
                     
                      
     
                      'gal_visible'=>'y'
                 );
     
                 $gal_id = $this->model_app->update('gallery',$data,array('gal_id'=>$id));
               
                $this->session->set_flashdata('success','Gallery Video berhasil diubah');
                redirect('internal/video/edit?id='.encode($id));
            }else{
                $this->session->set_flashdata('message','Gallery video Tidak ditemukan!');
                redirect('internal/video');
            }
        }else{
            $this->load->view('501');
        }
    }
    function deleteVideo(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('gallery_video',array('vid_id'=>$id));
            if($cek->num_rows() > 0){
                $status = true;
                $row = $cek->row_array();
                if($row['vid_embed'] == 'n'){
                    $path = './upload/berita/'.$row['vid_link'] ;
           
          
                     unlink($path);
                }
                
                $this->model_app->delete('gallery_video',array('vid_id'=>$id));
                $msg = null;
            }else{
                $status = false;
                $msg = 'video tidak ditemukan!';
            }
        }else{
            $this->load->view('501');
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }
    function delete(){
        __ceksess('internal/banjar/hapus');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('gallery',array('gal_id'=>$id,'gal_visible'=>'y'));
            if($cek->num_rows() > 0){
                // $this->model_app->update('users',array('users_jabatan'=>NULL),array('users_jabatan'=>$id));
                $this->model_app->update('gallery',array('gal_visible'=>'n'),array('gal_id'=>$id));
                $this->session->set_flashdata('success','Gallery video berhasil dihapus');
                redirect('internal/video/');
            }else{
                $this->session->set_flashdata('message','Gallery video Tidak ditemukan!');
                redirect('internal/video');
            }
        }
        
    }

}