<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banjar extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/banjar');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Banjar';
        $data['header'] = 'Banjar';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/banjar').'">Banjar</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_order('banjar','banjar_id','DESC');
        $this->template->load('template','mod_banjar/view_banjar',$data);
    }
    function add(){
        __ceksess('internal/banjar/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Banjar';
        $data['header'] = 'Tambah Banjar';
        

        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/banjar').'">Banjar</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template','mod_banjar/view_banjar_add',$data);

      
    }
    function edit(){
        __ceksess('internal/banjar/edit');

        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('banjar',array('banjar_id'=>$id));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Banjar';
                $data['header'] = 'Edit Banjar';
        
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/banjar').'">Banjar</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
        
                $data['js'] = '';
                $this->template->load('template','mod_banjar/view_banjar_edit',$data);
            }else{
                $this->session->set_flashdata('message','Banjar Tidak ditemukan!');
                redirect('internal/banjar');
            }
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post' || $this->input->post('name') != null || $this->input->post('address') != null){
            $banjar = $this->input->post('name');
            $address = $this->input->post('address');
            $data = array('banjar_name'=>$banjar,'banjar_address'=>$address,'banjar_kaling'=>NULL);
            $this->model_app->insert('banjar',$data);

            $this->session->set_flashdata('success','Banjar berhasil ditambah');
            redirect('internal/banjar');
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' || $this->input->post('name') != null || $this->input->post('address') != null){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('banjar',array('banjar_id'=>$id));
            if($cek->num_rows() > 0){
                $banjar = $this->input->post('name');
                $address = $this->input->post('address');
                $data = array('banjar_name'=>$banjar,'banjar_address'=>$address);
                $this->model_app->update('banjar',$data,array('banjar_id'=>$id));
                $this->session->set_flashdata('success','Banjar berhasil diubah');
                redirect('internal/banjar');
            }else{
                $this->session->set_flashdata('message','Banjar Tidak ditemukan!');
                redirect('internal/banjar');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/banjar/hapus');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('banjar',array('banjar_id'=>$id));
            if($cek->num_rows() > 0){
                // $this->model_app->update('users',array('users_jabatan'=>NULL),array('users_jabatan'=>$id));
                $this->model_app->delete('banjar',array('banjar_id'=>$id));
                $this->session->set_flashdata('success','Banjar berhasil dihapus');
                redirect('internal/banjar/');
            }else{
                $this->session->set_flashdata('message','Banjar Tidak ditemukan!');
                redirect('internal/banjar');
            }
        }
        
    }

}