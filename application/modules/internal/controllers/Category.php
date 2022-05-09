<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/category');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Kategori';
        $data['header'] = 'Kategori';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/category').'">Kategori</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_where_ordering('category',array('cat_visible'=>'y'),'cat_id','DESC');
        $this->template->load('template','mod_cat/view_cat',$data);
    }
    function add(){
        __ceksess('internal/category/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Kategori';
        $data['header'] = 'Tambah Kategori';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/category').'">Kategori</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template','mod_cat/view_cat_add',$data);

      
    }
    function edit(){
        __ceksess('internal/banjar/edit');

        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('category',array('cat_id'=>$id));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Kategori';
                $data['header'] = 'Edit Kategori';
        
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/category').'">Kategori</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
        
                $data['js'] = '';
                $this->template->load('template','mod_cat/view_cat_edit',$data);
            }else{
                $this->session->set_flashdata('message','Category Tidak ditemukan!');
                redirect('internal/category');
            }
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post' || $this->input->post('cat') != null){
           
            $config['upload_path']          = './upload/berita/';
            $config['encrypt_name'] = TRUE;
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 5000;
                
                    
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')){
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                $cat = $this->input->post('cat');
                $seo = seo($cat);
                $data = array('cat_category'=>$cat,'cat_seo'=>$seo,'cat_main_img'=>$foto,'cat_visible'=>'y');
                
                $this->model_app->insert('category',$data);

                $this->session->set_flashdata('success','Kategori berhasil ditambah');
                redirect('internal/category');
            }else{
                $msg = replace( array('<p>','</p>'),$this->upload->display_errors());
                $this->session->set_flashdata('message',$msg);
                redirect('internal/category/add');
            }
          
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' || $this->input->post('cat') != null ){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('category',array('cat_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $config['upload_path']          = './upload/berita/';
                $config['encrypt_name'] = TRUE;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 5000;
                    
                $cat = $this->input->post('cat');
                $seo = seo($cat);
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file')){
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                    $path = './upload/berita/'.$row['cat_main_img'] ;
           
          
                    unlink($path);
                   
                   
                }else{
                    $foto = $row['cat_main_img'];
                }

                $data = array('cat_category'=>$cat,'cat_seo'=>$seo,'cat_main_img'=>$foto);
                    
                $this->model_app->update('category',$data,array('cat_id'=>$id));

                $this->session->set_flashdata('success','Kategori berhasil diubah');
                redirect('internal/category');
            }else{
                $this->session->set_flashdata('message','Kategori Tidak ditemukan!');
                redirect('internal/category');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/category/delete');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('category',array('cat_id'=>$id));
            if($cek->num_rows() > 0){
                // $this->model_app->update('users',array('users_jabatan'=>NULL),array('users_jabatan'=>$id));
                $this->model_app->update('category',array('cat_visible'=>'y'),array('cat_Id'=>$id));
                $this->session->set_flashdata('success','Kategori berhasil dihapus');
                redirect('internal/category');
            }else{
                $this->session->set_flashdata('message','Kategori Tidak ditemukan!');
                redirect('internal/category');
            }
        }
        
    }

}