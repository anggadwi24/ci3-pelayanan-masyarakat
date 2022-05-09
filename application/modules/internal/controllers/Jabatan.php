<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/jabatan');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Jabatan';
        $data['header'] = 'Jabatan';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/jabatan').'">Jabatan</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_order('jabatan','jabatan_id','DESC');
        $this->template->load('template','mod_jabatan/view_jabatan',$data);
    }
    function add(){
        __ceksess('internal/jabatan/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Jabatan';
        $data['header'] = 'Tambah Jabatan';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/jabatan').'">Jabatan</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template','mod_jabatan/view_jabatan_add',$data);

      
    }
    function edit(){
        __ceksess('internal/jabatan/edit');

        if($this->input->method() == 'get'){
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('jabatan',array('jabatan_id'=>$id));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Jabatan';
                $data['header'] = 'Edit Jabatan';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';
        
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/jabatan').'">Jabatan</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
        
                $data['js'] = '';
                $this->template->load('template','mod_jabatan/view_jabatan_edit',$data);
            }else{
                $this->session->set_flashdata('message','Jabatan Tidak ditemukan!');
                redirect('internal/jabatan');
            }
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post' || $this->input->post('name') != null || $this->input->post('limit') != null){
            $jabatan = $this->input->post('name');
            $limit = $this->input->post('limit');
            $data = array('jabatan_name'=>$jabatan,'jabatan_limit'=>$limit,'jabatan_used'=>0);
            $this->model_app->insert('jabatan',$data);

            $this->session->set_flashdata('success','Jabatan berhasil ditambah');
            redirect('internal/jabatan/add');
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' || $this->input->post('name') != null || $this->input->post('limit') != null){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('jabatan',array('jabatan_id'=>$id));
            if($cek->num_rows() > 0){
                $jabatan = $this->input->post('name');
                $limit = $this->input->post('limit');
                $data = array('jabatan_name'=>$jabatan,'jabatan_limit'=>$limit,'jabatan_used'=>0);
                $this->model_app->update('jabatan',$data,array('jabatan_id'=>$id));
                $this->session->set_flashdata('success','Jabatan berhasil diubah');
                redirect('internal/jabatan/');
            }else{
                $this->session->set_flashdata('message','Jabatan Tidak ditemukan!');
                redirect('internal/jabatan');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/jabatan/hapus');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('jabatan',array('jabatan_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->update('users',array('users_jabatan'=>NULL),array('users_jabatan'=>$id));
                $this->model_app->delete('jabatan',array('jabatan_id'=>$id));
                $this->session->set_flashdata('success','Jabatan berhasil dihapus');
                redirect('internal/jabatan/');
            }else{
                $this->session->set_flashdata('message','Jabatan Tidak ditemukan!');
                redirect('internal/jabatan');
            }
        }
        
    }

}