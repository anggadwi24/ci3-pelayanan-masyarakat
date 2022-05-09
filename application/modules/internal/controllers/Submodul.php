<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Submodul extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));


    }

    public function index() {
        __ceksess('internal/submodul');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Submodul';
        $data['header'] = 'Submodul';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/submodul').'">Submodul</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->join_where_order2('submodul','modul','submodul_modul_id','modul_id',array('submodul_visible'=>'y'),'submodul_id','DESC');
        $this->template->load('template','mod_modul/view_submodul',$data);


    }
    function add(){
        __ceksess('internal/submodul/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Submodul';
        $data['header'] = 'Tambah Submodul';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';
        $data['modul'] = $this->model_app->view_where_ordering('modul',array('modul_visible'=>'y'),'modul_id','DESC');
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/submodul').'">Submodul</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';

        $data['js'] = base_url('template/admin/ajax/management/ajax-management.js');
        
        $this->template->load('template','mod_modul/view_submodul_add',$data);

      
    }
    function store(){
        if($this->input->method() == 'post' AND decode($this->input->post('modul'))){
            $sub = $this->input->post('submodul');
            $link = $this->input->post('link');
            $publish = $this->input->post('publish');
            $modul = decode($this->input->post('modul'));
            $count = count($sub);
            for($a=0;$a<$count;$a++){
                if($sub[$a] != null && $link[$a] != null && $publish[$a] != null){
                    $data = array(
                        'submodul_name'=>$sub[$a],
                        'submodul_link'=>$link[$a],
                        'submodul_publish'=>$publish[$a],
                        'submodul_modul_id'=>$modul,
                        'submodul_visible'=>'y'
                    );
                    $this->model_app->insert('submodul',$data);
                }
            }
            $this->session->set_flashdata('sukses','Data Berhasil Disimpan');
            redirect('internal/submodul');
        }else{
            $this->load->view('501');
        }
    }
    function edit(){
        __ceksess('internal/submodul/edit');

        $id = decode($this->input->get('id'));
       
        $cek = $this->model_app->view_where('submodul',array('submodul_visible'=>'y','submodul_id'=>$id));
       
        if($cek->num_rows() > 0){
            $data['row'] = $cek->row_array();
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Submodul';
            $data['header'] = 'Edit Submodul';
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Management</a></li>';
            $data['modul'] = $this->model_app->view_where_ordering('modul',array('modul_visible'=>'y'),'modul_id','DESC');

            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/submodul').'">Submodul</a></li>';
            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';

            $data['js'] = '';
            $this->template->load('template','mod_modul/view_submodul_edit',$data); 
        }else{
            $this->session->set_flashdata('message','Submodul Tidak Ditemuakn!');
            redirect('internal/submodul');

        }
    }
    
    function update(){
        
        if($this->input->method() == 'post' && $this->input->post('submodul_name') != ''){
            $id =decode($this->input->post('id'));
            $cek = $this->model_app->view_where('submodul',array('submodul_visible'=>'y','submodul_id'=>$id));

            if($cek->num_rows() > 0){
                $data = array(
                    'submodul_name'=>$this->input->post('submodul_name'),
                    'submodul_link'=>$this->input->post('submodul_link'),
                    'submodul_publish'=>$this->input->post('submodul_publish'),
                    'submodul_modul_id'=>decode($this->input->post('submodul_modul_id')),
                    
                );
                $this->model_app->update('submodul',$data,array('submodul_id'=>$id));
                $this->session->set_flashdata('success','Submodul berhasil diubah');
                redirect('internal/submodul');
            }else{
                $this->session->set_flashdata('message','Submodul Tidak Ditemukan!');
                redirect('internal/submodul');
            }
           
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/submodul/delete');

        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('submodul',array('submodul_visible'=>'y','submodul_id'=>$id));
        if($cek->num_rows() > 0){
            $this->model_app->update('submodul',array('submodul_visible'=>'n'),array('submodul_id'=>$id));
            $this->session->set_flashdata('success','Submodul berhasil dihapus');
            redirect('internal/submodul');
        }else{
            $this->session->set_flashdata('message','Submodul Tidak Ditemukan!');
            redirect('internal/submodul');
        }
    }



    

    

}
