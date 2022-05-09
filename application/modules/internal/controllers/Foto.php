<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/foto');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Foto';
        $data['header'] = 'Foto';

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/foto').'">Foto</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_where_ordering('gallery',array('gal_visible'=>'y','gal_status'=>'photo'),'gal_id','DESC');
        $this->template->load('template','mod_gallery/view_foto',$data);
    }
    function add(){
        __ceksess('internal/foto/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Foto';
        $data['header'] = 'Tambah Foto';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/foto').'">Foto</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template_upload','mod_gallery/view_foto_add',$data);

      
    }
    function edit(){
        __ceksess('internal/foto/edit');

        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('gallery',array('gal_id'=>$id,'gal_status'=>'photo','gal_visible'=>'y'));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Foto';
                $data['header'] = 'Edit Foto';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a>Gallery</a></li>';
        
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/foto').'">Foto</a></li>';

                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
        
                $data['js'] = '';
                $this->template->load('template_upload','mod_gallery/view_foto_edit',$data);
            }else{
                $this->session->set_flashdata('message','Gallery Tidak ditemukan!');
                redirect('internal/foto');
            }
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post' || $this->input->post('title') != null){
            $config1['upload_path']          = './upload/berita/';
            $config1['encrypt_name'] = TRUE;
            $config1['allowed_types']        = 'gif|jpg|png|jpeg';
            $config1['max_size']             = 3000;
                
            $this->load->library('upload', $config1,'main');
                    
            // $this->load->library('upload', $config);
            if ($this->main->do_upload('file')){
                $upload_data = $this->main->data();
                $thumbnail = $upload_data['file_name'];
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
                        'gal_status'=>'photo',
                        'gal_thumbnail'=>$thumbnail,
                        'gal_views'=>0,
                        

                        'gal_visible'=>'y'
                    );

                $gal_id = $this->model_app->insert_id('gallery',$data);
                    
                $count = count($_FILES['files']['name']);
    
                for($i=0;$i<$count;$i++){
                    if(!empty($_FILES['files']['name'][$i])){
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                
                        $config['upload_path'] =  './upload/berita/'; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '5000';
                        $config['encrypt_name'] = TRUE;


                        $this->load->library('upload', $config,'gallery');
                        $this->gallery->initialize($config);
                        $this->gallery->do_upload('file');
                
                    
                        
                        
                        $uploadData = $this->gallery->data();
                        $images = $uploadData['file_name'];
                        $dataP = array(
                            'photo_gal_id'=>$gal_id,
                            'photo_link'=>$images,
                            'photo_date'=>$date,
                            'photo_update_by'=>$created_by,
                            
                        );
                        $this->model_app->insert('gallery_photo',$dataP);



                    }
                }
            
                $this->session->set_flashdata('success','Data Berhasil Disimpan');
                redirect('internal/foto');
            }else{
                $this->session->set_flashdata('message',$this->main->display_errors());
                redirect('internal/foto/add');
            }
           
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' || $this->input->post('cat') != null ){
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
                 
                 $count = count($_FILES['files']['name']);
            
                 for($i=0;$i<$count;$i++){
                     if(!empty($_FILES['files']['name'][$i])){
                         $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                         $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                         $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                         $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                         $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                 
                         $config['upload_path'] =  './upload/berita/'; 
                         $config['allowed_types'] = 'jpg|jpeg|png|gif';
                         $config['max_size'] = '5000';
                         $config['encrypt_name'] = TRUE;
                     
                 
                         $this->load->library('upload',$config); 
                         $this->upload->do_upload('file');
                         
                         
                         $uploadData = $this->upload->data();
                         $images = $uploadData['file_name'];
                         $dataP = array(
                             'photo_gal_id'=>$id,
                             'photo_link'=>$images,
                             'photo_date'=>$date,
                             'photo_update_by'=>$created_by,
                             
                         );
                         $this->model_app->insert('gallery_photo',$dataP);
     
     
     
                     }
                 }

                $this->session->set_flashdata('success','Gallery Foto berhasil diubah');
                redirect('internal/foto/edit?id='.encode($id));
            }else{
                $this->session->set_flashdata('message','Gallery Foto Tidak ditemukan!');
                redirect('internal/foto');
            }
        }else{
            $this->load->view('501');
        }
    }
    function deletePhoto(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('gallery_photo',array('photo_id'=>$id));
            if($cek->num_rows() > 0){
                $status = true;
                $row = $cek->row_array();
                $path = './upload/berita/'.$row['photo_link'] ;
           
          
                unlink($path);
                $this->model_app->delete('gallery_photo',array('photo_id'=>$id));
                $msg = null;
            }else{
                $status = false;
                $msg = 'Foto tidak ditemukan!';
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
                $this->session->set_flashdata('success','Gallery Foto berhasil dihapus');
                redirect('internal/foto/');
            }else{
                $this->session->set_flashdata('message','Gallery Foto Tidak ditemukan!');
                redirect('internal/foto');
            }
        }
        
    }

}