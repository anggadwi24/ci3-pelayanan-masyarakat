<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    
    function index(){
      
        __ceksess('internal/berita');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Berita';
        $data['header'] = 'Berita';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/berita').'">Berita</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_where_ordering('berita',array('berita_visible'=>'y'),'berita_id','DESC');
        $this->template->load('template','mod_news/view_news',$data);
        
    }
    function add(){
        __ceksess('internal/berita/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Berita';
        $data['header'] = 'Tambah Berita';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/berita').'">Berita</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a>Tambah</a></li>';

        $data['js'] = base_url('template/admin/ajax/news/ajax-add.js');
        $data['category'] = $this->model_app->view_where_ordering('category',array('cat_visible'=>'y'),'cat_id','DESC');
        $data['tags'] = $this->model_app->view_where_ordering('tag',array('tag_visible'=>'y'),'tag_id','DESC');
        $this->template->load('template_upload','mod_news/view_news_add',$data);
    }
    function detail(){
        __ceksess('internal/berita/detail');
        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
        if($cek->num_rows() > 0){
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Berita';
            $data['row'] = $cek->row_array();
            $data['header'] = 'Detail Berita';
            
    
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/berita').'">Berita</a></li>';
            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a>Detail</a></li>';
    
            $data['js'] = '';
            $data['category'] = $this->model_app->join_where_order2('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$id),'bc_id','DESC');
            $data['image'] = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'y'))->row_array();
            $data['detail'] = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'n'));

            $data['tags'] = $this->model_app->view_where_ordering('tag',array('tag_visible'=>'y'),'tag_id','DESC');
            $this->template->load('template_upload','mod_news/view_news_detail',$data);
        }else{
            $this->session->set_flashdata('message','Berita tidak ditemukan!');
            redirect('internal/berita');
        }
       
    }
    function edit(){
        __ceksess('internal/berita/edit');
        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
        if($cek->num_rows() > 0){
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Berita';
            $data['row'] = $cek->row_array();
            $data['header'] = 'Edit Berita';
            
    
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/berita').'">Berita</a></li>';
            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a>Edit</a></li>';
    
            $data['js'] = base_url('template/admin/ajax/news/ajax-edit.js');

            $data['category'] = $this->model_app->view_where_ordering('category',array('cat_visible'=>'y'),'cat_id','DESC');

            $data['image'] = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'y'))->row_array();
            $data['detail'] = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'n'));

            $data['tags'] = $this->model_app->view_where_ordering('tag',array('tag_visible'=>'y'),'tag_id','DESC');
            $this->template->load('template_upload','mod_news/view_news_edit',$data);
        }else{
            $this->session->set_flashdata('message','Berita tidak ditemukan!');
            redirect('internal/berita');
        }
       
    }
    function updateMain(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
            if($cek->num_rows() > 0){
                $config['upload_path']          = './upload/berita/';
                $config['encrypt_name'] = TRUE;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 3000;
                    
                $this->load->library('upload', $config,'main');
                        
                // $this->load->library('upload', $config);
                if ($this->main->do_upload('file')){
                    $upload_data = $this->main->data();
					$main = $upload_data['file_name'];
                    $status = true;
                    $cekIm = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'y'));
                    if($cekIm->num_rows()> 0){
                        $rowIm = $cekIm->row_array();
                        $path = './upload/berita/'.$rowIm['bgal_link'] ;
           
          
                        unlink($path);
                         $this->model_app->update('berita_gallery',array('bgal_link'=>$main),array('bgal_id'=>$rowIm['bgal_id']));
                    }else{
                        $this->model_app->insert('berita_gallery',array('bgal_link'=>$main));

                    }
                    $status= true;
                    $msg = 'Main Image berhasil diubah!';
                }else{
                    $status =false;
                    $msg = replace( array('<p>','</p>'),$this->upload->display_errors());
                }
                
            }else{
                $status = false;
                $msg = 'Berita tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function deleteDetail(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('berita_gallery',array('bgal_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $path = './upload/berita/'.$row['bgal_link'] ;
                unlink($path);
                $this->model_app->delete('berita_gallery',array('bgal_id'=>$id));
                $status= true;
                $msg = 'Image berhasil dihapus!';
            }else{
                $status =false;
                $msg = 'Image tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function storeDetail(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
            if($cek->num_rows() > 0){
                $count = count($_FILES['files']['name']);
                for($x=0;$x<$count;$x++){
                    if(!empty($_FILES['files']['name'][$x])){
                        $_FILES['file']['name'] = $_FILES['files']['name'][$x];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$x];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$x];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$x];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$x];
                
                        $config2['upload_path']          = './upload/berita/';
                        $config2['encrypt_name'] = TRUE;
                        $config2['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config2['max_size']             = 3000;
                            
                                
                        $this->load->library('upload', $config2,'gallery');
                        $this->gallery->initialize($config2);
                        $this->gallery->do_upload('file');
                        
                        
                        $uploadData = $this->gallery->data();
                        $images = $uploadData['file_name'];
                        $dataP = array(
                            'bgal_berita_id'=>$id,
                            'bgal_link'=>$images,
                            'bgal_main_img'=>'n',
                            
                            
                        );
                        $this->model_app->insert('berita_gallery',$dataP);
    
    
    
                    }
                }
                $status = true;
                $msg = 'Detail Image berhasil ditambah!';
                
            }else{
                $status = false;
                $msg = 'Berita tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function detailImage(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
            if($cek->num_rows() > 0){
                $status = true;
                $output = null;
                $data = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$id,'bgal_main_img'=>'n'));
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        if(file_exists('upload/berita/'.$row['bgal_link'])){
                            $img = base_url('upload/berita/'.$row['bgal_link']);
                        }else{
                            $img = base_url('upload/berita/default.jpg');
                        }
                        $output .= "<div class='col-12 mb-2'>
                        <img class='img-fluid' src='".$img."'> 
                        <span class='feather icon-trash delete float-right d-block mt-2 text-danger' style='font-size:20px;' data-id='".encode($row['bgal_id'])."'></span>
                      </div>";
                    }
                }
                
            }else{
                $status = false;
                $output =null;
            }
            echo json_encode(array('status'=>$status,'output'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post'){
           $id = decode($this->input->post('id'));
           $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
           if($cek->num_rows() > 0){
            $this->form_validation->set_rules('judul_berita','Judul Berita','min_length[10]|max_length[255]|required');
            if($this->form_validation->run() == FALSE){
                $status = false;
                $replace = array('<p>','</p>');
                $msg = replace($replace,validation_errors());
                
            }else{
                  
                $title = $this->input->post('judul_berita');
                $desc = $this->input->post('isi_berita');
                $cat = $this->input->post('category');
                $tag = $this->input->post('tags');
                
                $seo = $this->model_app->seo_berita_updae(seo($title),$id);
              
                $tagContent = null;
                if($tag != null OR $tag != ''){
                    $countTags = count($tag);
                    for($a=0;$a<$countTags;$a++){
                        $seoTag = seo($tag[$a]);
                        $cekSeo = $this->model_app->view_where('tag',array('tag_seo'=>$seoTag));
                        if($cekSeo->num_rows() == 0 ){
                            $dataSeo = array('tag_seo'=>$seoTag,'tag_name'=>$tag[$a],'tag_visible'=>'y');
                            $this->model_app->insert('tag',$dataSeo);
                            $tagContent .= $seoTag.',';
                        }else{
                            $tagContent .= $seoTag.',';
    
                        }
                    }
                }
                
                $publish = $this->input->post('publish');
                if($publish){
                    $pub = 'y';
                    $date= $this->input->post('publish_on');
                    $pubDate = date('Y-m-d H:i:s',strtotime($date));
                }else{
                    $pub = 'n';
                    $pubDate = null;
                }

                $data = array('berita_title'=>$title,
                                'berita_desc'=>$desc,
                               
                                'berita_publish'=>$pub,
                                'berita_publish_on'=>$pubDate,
                                'berita_tag'=>substr_replace($tagContent, "", -1),
                                'berita_seo'=>$seo,
                              );
                $berita_id = $this->model_app->update('berita',$data,array('berita_id'=>$id));
                
                if($cat != "" OR $cat != null){
                    $this->model_app->delete('berita_category',array('bc_berita_id'=>$id));
                    $countCat = count($cat);
                    for($i=0;$i<$countCat;$i++){
                        $dataCat = array('bc_berita_id'=>$id,'bc_category'=>$cat[$i]);
                        $this->model_app->insert('berita_category',$dataCat);
                    }
                }
               

               
                $status= true;
                $msg = 'Berita berhasil ditambahkan';
                       
					
            }
           }else{
               $status= false;
               $msg = 'Berita tidak ditemukan';
           }
           
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function store(){
        if($this->input->method() == 'post'){
           
            $this->form_validation->set_rules('judul_berita','Judul Berita','min_length[10]|max_length[255]|required');
            if($this->form_validation->run() == FALSE){
                $status = false;
                $replace = array('<p>','</p>');
                $msg = replace($replace,validation_errors());
                
            }else{
                    $config['upload_path']          = './upload/berita/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types']        = 'gif|jpg|png|jpeg';
					$config['max_size']             = 3000;
						
                    $this->load->library('upload', $config,'main');
							
					// $this->load->library('upload', $config);
					if ($this->main->do_upload('file')){
                        $upload_data = $this->main->data();
						$main = $upload_data['file_name'];
                    }else{
                        $main = null;
                    }
						
                        $title = $this->input->post('judul_berita');
                        $desc = $this->input->post('isi_berita');
                        $cat = $this->input->post('category');
                        $tag = $this->input->post('tags');
                        
                        $seo = $this->model_app->seo_berita(seo($title));
                        
                        $tagContent = null;
                        if($tag != ''){
                            $countTags = count($tag);
                            for($a=0;$a<$countTags;$a++){
                                $seoTag = seo($tag[$a]);
                                $cekSeo = $this->model_app->view_where('tag',array('tag_seo'=>$seoTag));
                                if($cekSeo->num_rows() == 0 ){
                                    $dataSeo = array('tag_seo'=>$seoTag,'tag_name'=>$tag[$a],'tag_visible'=>'y');
                                    $this->model_app->insert('tag',$dataSeo);
                                    $tagContent .= $seoTag.',';
                                }else{
                                    $tagContent .= $seoTag.',';
    
                                }
                            }
                        }
                       
                        $publish = $this->input->post('publish');
                        if($publish){
                            $pub = 'y';
                            $pubDate = date('Y-m-d H:i:s',strtotime($this->input->post('publish_on')));
                        }else{
                            $pub = 'n';
                            $pubDate = null;
                        }

                        $data = array('berita_title'=>$title,
                                      'berita_desc'=>$desc,
                                      'berita_views'=>0,
                                      'berita_publish'=>$pub,
                                      'berita_publish_on'=>$pubDate,
                                      'berita_tag'=>substr_replace($tagContent, "", -1),
                                      'berita_seo'=>$seo,
                                      'berita_created_by'=>decode($this->session->userdata['internal']['id']),
                                      'berita_visible'=>'y');
                        $berita_id = $this->model_app->insert_id('berita',$data);

                        
                        if($cat != ''){
                            $countCat = count($cat);
                            for($i=0;$i<$countCat;$i++){
                                $dataCat = array('bc_berita_id'=>$berita_id,'bc_category'=>$cat[$i]);
                                $this->model_app->insert('berita_category',$dataCat);
                            }
                        }
                       
                        if($main != null){
                            $dataImg = array('bgal_berita_id'=>$berita_id,'bgal_link'=>$main,'bgal_main_img'=>'y');
                        $this->model_app->insert('berita_gallery',$dataImg);
                            }
                        

                        $count = count($_FILES['files']['name']);
                        if($count > 0){
                            for($x=0;$x<$count;$x++){
                                if(!empty($_FILES['files']['name'][$x])){
                                    $_FILES['file']['name'] = $_FILES['files']['name'][$x];
                                    $_FILES['file']['type'] = $_FILES['files']['type'][$x];
                                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$x];
                                    $_FILES['file']['error'] = $_FILES['files']['error'][$x];
                                    $_FILES['file']['size'] = $_FILES['files']['size'][$x];
                            
                                    $config2['upload_path']          = './upload/berita/';
                                    $config2['encrypt_name'] = TRUE;
                                    $config2['allowed_types']        = 'gif|jpg|png|jpeg';
                                    $config2['max_size']             = 20000;
                                        
                                            
                                    $this->load->library('upload', $config2,'gallery');
                                    $this->gallery->initialize($config2);
                                    $this->gallery->do_upload('file');
                                    
                                    
                                    $uploadData = $this->gallery->data();
                                    $images = $uploadData['file_name'];
                                    $dataP = array(
                                        'bgal_berita_id'=>$berita_id,
                                        'bgal_link'=>$images,
                                        'bgal_main_img'=>'n',
                                        
                                        
                                    );
                                    $this->model_app->insert('berita_gallery',$dataP);
                
                
                
                                }
                            }
                        }
                       
                        $status= true;
                        $msg = 'Berita berhasil ditambahkan';
                       
					
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek = $this->model_app->view_where('berita',array('berita_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->update('berita',array('berita_visible'=>'n'),array('berita_id'=>$id));
                $this->session->set_flashdata('success','Berita berhasil dihapus');
            }else{
                $this->session->set_flashdata('message','Berita tidak ditemukan!');
            }
            redirect('internal/berita');
        }else{
            $this->load->view('501');
        }
        
    }
}