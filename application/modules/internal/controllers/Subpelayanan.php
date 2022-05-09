<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subpelayanan extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/subpelayanan');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Sub Pelayanan';
        $data['header'] = 'Sub Pelayanan';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Pelayanan</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/subpelayanan').'">Sub Pelayanan</a></li>';
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $data['record'] = $this->model_app->join_where_order2('pelayanan','sub_pelayanan','pelayanan_id','subpel_pelayanan_id',array('pelayanan_visible'=>'y','subpel_visible'=>'y'),'pelayanan_name','ASC');
        $this->template->load('template','mod_pelayanan/view_sub',$data);
    }
    function add(){
        __ceksess('internal/subpelayanan/add');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Sub Pelayanan';
        $data['header'] = 'Tambah Sub Pelayanan';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Pelayanan</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/subpelayanan').'">Sub Pelayanan</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';
        $data['record'] = $this->model_app->view_where_ordering('pelayanan',array('pelayanan_visible'=>'y'),'pelayanan_name','ASC');
        $data['js'] = base_url('template/admin/ajax/pelayanan/ajax-sub.js');

        $this->template->load('template','mod_pelayanan/view_sub_add',$data);

      
    }
 
    function edit(){
       __ceksesskonten('internal/subpelayanan/edit');

        if($this->input->method() == 'get'){
          
        
            $id = decode($this->input->get('id'));
            $cek= $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $data['row'] = $row;
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Sub Pelayanan';
                $data['header'] = 'Edit Sub Pelayanan';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Pelayanan</a></li>';
        
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/subpelayanan').'">Sub Pelayanan</a></li>';
        
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
                $data['record'] = $this->model_app->view_where_ordering('pelayanan',array('pelayanan_visible'=>'y'),'pelayanan_name','ASC');
                $data['js'] = '';
        
                $this->template->load('template','mod_pelayanan/view_sub_edit',$data);
               

            }else{
              $this->session->set_flashdata('message','Data tidak ditemukan');
              redirect('internal/subpelayanan');
            }
            
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post'){
            $pelayanan = decode($this->input->post('pelayanan'));
            $cek = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$pelayanan));
            if($cek->num_rows() > 0){
                
                $sub = $this->input->post('subpelayanan');
                $link = $this->input->post('link');
                $count = count($sub);
                if($count > 0){
                    $status = true;
                    
                    for($a = 0;$a<$count;$a++){
                        if($sub[$a] != '' AND $link[$a] != ''){
                            $data = array(
                                'subpel_pelayanan_id'=>$pelayanan,
                                'subpel_name'=>$sub[$a],
                                'subpel_link'=>$link[$a],
                                'subpel_created_by'=>decode($this->session->userdata['internal']['id']),
                                'subpel_created_on'=>date('Y-m-d H:i:s')
                            );
                            $this->model_app->insert('sub_pelayanan',$data);
                        }
                        
                    }
                    $msg = 'Data berhasil disimpan';
                }else{
                    $status = false;
                    $msg = 'Tidak ada data yang diinput';
                }
            }else{
                $status = false;
                $msg = 'Pelayanan tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
            
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' AND $this->input->post('subpelayanan') != null AND $this->input->post('id') != null AND $this->input->post('link')){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$id));
            if($cek->num_rows() > 0){
                $pelayanan = decode($this->input->post('pelayanan'));
                $cek = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$pelayanan));
                if($cek->num_rows() > 0){
                    $data = array('subpel_pelayanan_id'=>$pelayanan,'subpel_name'=>$this->input->post('subpelayanan'),'subpel_link'=>$this->input->post('link'));
             
                    $this->model_app->update('sub_pelayanan',$data,array('subpel_id'=>$id));
                    $this->session->set_flashdata('success','Sub Pelayann berhasil diubah');
                    redirect('internal/subpelayanan');
                }else{
                    $this->session->set_flashdata('message','Pelayanan Tidak ditemukan!');
                    redirect('internal/subpelayanan');
                }
                 
            }else{
                $this->session->set_flashdata('message','Subpelayanan Tidak ditemukan!');
                redirect('internal/subpelayanan');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/subpelayanan/delete');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->update('sub_pelayanan',array('subpel_visible'=>'n'),array('subpel_id'=>$id));
                // $this->model_app->delete('jabatan',array('jabatan_id'=>$id));
                $this->session->set_flashdata('success','Sub Pelayanan berhasil dihapus');
                redirect('internal/subpelayanan');
            }else{
                $this->session->set_flashdata('message','Sub Pelayanan Tidak ditemukan!');
                redirect('internal/subpelayanan');
            }
        }
        
    }

}