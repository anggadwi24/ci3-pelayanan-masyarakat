<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/pelayanan');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Pelayanan';
        $data['header'] = 'Pelayanan';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Pelayanan</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/pelayanan').'">Pelayanan</a></li>';
        $data['js'] = base_url('template/admin/ajax/pelayanan/ajax-pelayanan.js');
        $data['record'] = $this->model_app->view_where_ordering('pelayanan',array('pelayanan_visible'=>'y'),'pelayanan_name','ASC');
        $this->template->load('template','mod_pelayanan/view_pelayanan',$data);
    }
 
    function edit(){
       

        if($this->input->method() == 'post'){
           $status =  __ceksesskonten('internal/pelayanan/edit');
           if($status == true){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $status = true;
                $msg = null;
                $arr = array('pelayanan'=>$row['pelayanan_name'],'id'=>encode($row['pelayanan_id']));

            }else{
                $status= false;
                $msg = 'Pelayanan tidak ditemukan!';
                $arr =null;
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'arr'=>$arr));
           }else{
            $status = false;
            $msg = 'Unathorize';
            echo json_encode(array('status'=>$status,'msg'=>$msg));
           }
           
              
           
        }else{
            $this->load->view('501');
        }
       

      
    }
    function store(){
        if($this->input->method() == 'post' AND $this->input->post('pelayanan') != null){
            $pelayanan = $this->input->post('pelayanan');
            $id = decode($this->session->userdata['internal']['id']);
            $data = array('pelayanan_name'=>$pelayanan,'pelayanan_created_by'=>$id,'pelayanan_visible'=>'y');
            $this->model_app->insert('pelayanan',$data);

            $this->session->set_flashdata('success','Pelayanan berhasil ditambah');
            redirect('internal/pelayanan');
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' AND $this->input->post('pelayanan') != null AND $this->input->post('id') != null){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$id));
            if($cek->num_rows() > 0){
                $pelayanan = $this->input->post('pelayanan');
                 $data = array('pelayanan_name'=>$pelayanan);
             
                $this->model_app->update('pelayanan',$data,array('pelayanan_id'=>$id));
                $this->session->set_flashdata('success','Pelayanan berhasil diubah');
                redirect('internal/pelayanan');
            }else{
                $this->session->set_flashdata('message','Pelayanan Tidak ditemukan!');
                redirect('internal/pelayanan');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/pelayanan/delete');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->update('pelayanan',array('pelayanan_visible'=>'n'),array('pelayanan_id'=>$id));
                // $this->model_app->delete('jabatan',array('jabatan_id'=>$id));
                $this->session->set_flashdata('success','Pelayanan berhasil dihapus');
                redirect('internal/pelayanan');
            }else{
                $this->session->set_flashdata('message','Pelayanan Tidak ditemukan!');
                redirect('internal/pelayanan');
            }
        }
        
    }

}