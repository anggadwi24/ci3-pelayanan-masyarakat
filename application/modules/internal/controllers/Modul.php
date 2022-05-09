<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modul extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));


    }

    public function index() {
        __ceksess('internal/modul/');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Modul';
        $data['header'] = 'Modul';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/modul').'">Modul</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->view_order('modul','modul_id','DESC');
        $this->template->load('template','mod_modul/view_modul',$data);


    }
    function add(){
        __ceksess('internal/modul/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Modul';
        $data['header'] = 'Tambah Modul';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/modul').'">Modul</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = '';
        $this->template->load('template','mod_modul/view_modul_add',$data);

      
    }
    function edit(){
        __ceksess('internal/modul/edit');

        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('modul',array('modul_id'=>$id,'modul_visible'=>'y'));
        if($cek->num_rows() > 0){
            $data['row'] = $cek->row_array();
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Modul';
            $data['header'] = 'Edit Modul';
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/modul').'">Modul</a></li>';
            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';

            $data['js'] = '';
            $this->template->load('template','mod_modul/view_modul_edit',$data); 
        }else{
            $this->session->set_flashdata('message','Modul Tidak Ditemuakn!');
            redirect('internal/modul');

        }
    }
    function store(){
        if($this->input->method() == 'post' && $this->input->post('modul_name') != ''){
            $data = array(
                'modul_name' => $this->input->post('modul_name'),
                'modul_icon' => $this->input->post('modul_icon'),
                'modul_order' => $this->input->post('modul_order'),
                'modul_url' => $this->input->post('modul_url'),
              
               
            );
            $this->model_app->insert('modul',$data);
            $this->session->set_flashdata('success','Modul berhasil ditambahkan');
            redirect('internal/modul');
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        
        if($this->input->method() == 'post' && $this->input->post('modul_name') != ''){
            $id =decode($this->input->post('id'));
            $cek = $this->model_app->view_where('modul',array('modul_id'=>$id,'modul_visible'=>'y'));
            if($cek->num_rows() > 0){
                $data = array(
                    'modul_name' => $this->input->post('modul_name'),
                    'modul_icon' => $this->input->post('modul_icon'),
                    'modul_order' => $this->input->post('modul_order'),
                    'modul_url' => $this->input->post('modul_url'),
                  
                   
                );
                $this->model_app->update('modul',$data,array('modul_id'=>$id));
                $this->session->set_flashdata('success','Modul berhasil diubah');
                redirect('internal/modul');
            }else{
                $this->session->set_flashdata('message','Modul Tidak Ditemukan!');
                redirect('internal/modul');
            }
           
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/modul/delete');

        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('modul',array('modul_id'=>$id,'modul_visible'=>'y'));
        if($cek->num_rows() > 0){
            $this->model_app->update('modul',array('modul_visible'=>'n'),array('modul_id'=>$id));
            $this->session->set_flashdata('success','Modul berhasil dihapus');
            redirect('internal/modul');
        }else{
            $this->session->set_flashdata('message','Modul Tidak Ditemukan!');
            redirect('internal/modul');
        }
    }



    

    

}
