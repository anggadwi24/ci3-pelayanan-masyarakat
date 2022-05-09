<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        __ceksess('internal/menu');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Menu';
        $data['header'] = 'Menu';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Website</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/menu').'">Menu</a></li>';
        $data['js'] = base_url('template/admin/ajax/website/ajax-menu.js');
        $data['record'] = $this->model_app->view_order('menu','menu_name','ASC');
        $this->template->load('template','mod_website/view_menu',$data);
    }
 
    function edit(){
       

        if($this->input->method() == 'post'){
           $status =  __ceksesskonten('internal/menu/edit');
           if($status == true){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('menu',array('menu_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $status = true;
                $msg = null;
                $arr = array('menu'=>$row['menu_name'],'id'=>encode($row['menu_id']),'url'=>$row['menu_link']);

            }else{
                $status= false;
                $msg = 'Menu tidak ditemukan!';
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
        if($this->input->method() == 'post' AND $this->input->post('menu') != null AND $this->input->post('url') != null){
            $menu = $this->input->post('menu');
            $url = $this->input->post('url');

            $id = decode($this->session->userdata['internal']['id']);
            $data = array('menu_name'=>$menu,'menu_created_by'=>$id,'menu_link'=>$url);
            $this->model_app->insert('menu',$data);

            $this->session->set_flashdata('success','Menu berhasil ditambah');
            redirect('internal/menu');
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        if($this->input->method() == 'post' AND $this->input->post('menu') != null AND $this->input->post('url') != null){
            $id = decode($this->input->post('id'));
            $cek= $this->model_app->view_where('menu',array('menu_id'=>$id));
            if($cek->num_rows() > 0){
                $menu = $this->input->post('menu');
                $url = $this->input->post('url');
                $data = array('menu_name'=>$menu,'menu_link'=>$url);
                 
             
                $this->model_app->update('menu',$data,array('menu_id'=>$id));
                $this->session->set_flashdata('success','Menu berhasil diubah');
                redirect('internal/menu');
            }else{
                $this->session->set_flashdata('message','Menu Tidak ditemukan!');
                redirect('internal/menu');
            }
        }else{
            $this->load->view('501');
        }
    }
    function delete(){
        __ceksess('internal/menu/delete');
        $id = decode($this->input->get('id'));
        if($this->input->method() == 'get'){
            $cek= $this->model_app->view_where('menu',array('menu_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->delete('menu',array('menu_id'=>$id));
                // $this->model_app->delete('jabatan',array('jabatan_id'=>$id));
                $this->session->set_flashdata('success','Menu berhasil dihapus');
                redirect('internal/menu');
            }else{
                $this->session->set_flashdata('message','Menu Tidak ditemukan!');
                redirect('internal/menu');
            }
        }
        
    }

}