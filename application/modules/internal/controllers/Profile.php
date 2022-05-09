<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function index(){
        $id = decode($this->session->userdata['internal']['id']);
        $user = $this->model_app->view_where('users',array('users_id'=>$id));
        if($user->num_rows() > 0){
            $data['row'] = $user->row_array();
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Profile';
            $data['header'] = 'Profile';
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/profile').'">Profile</a></li>';
            $data['js'] = base_url('template/admin/ajax/profile/ajax-profile.js');
          
            $this->template->load('template','mod_profile/view_profile',$data);
        }else{
            $this->session->set_flashdata('mesage','Akun tidak ditemukan!');
            redirect('internal/logout');
        }
    }  
    function updateImage(){
        if($this->input->method() == 'post'){
            $url = null;
            $msg = null;
            $id = decode($this->session->userdata['internal']['id']);
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() > 0){
                $config['upload_path']          = './upload/users/';
                $config['encrypt_name'] = TRUE;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 3000;
                    
                        
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('file')){
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                    $url = base_url('upload/users/').$foto;
                    $this->model_app->update('users',array('users_photo'=>$foto),array('users_id'=>$id));
                    $status = true;
                }else{
                   $status = false;

                   $msg = replace(array('<p>','</p>'),$this->upload->display_errors());
                }
            }else{
                $status= false;
                $msg = 'Users not found!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'url'=>$url));
        }else{
            $this->load->view('501');
        }
    } 
    function update(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() > 0){
                $row= $cek->row_array();
                $email = $this->input->post('email');
                if($email != $row['users_email']){
                    $cekEmail = $this->db->query("SELECT * FROM users WHERE users_email='$email' AND users_email != '$row[users_email]'");
                    if($cekEmail->num_rows() > 0){
                        $status = false;
                        $msg= 'Email telah digunakan!';
                    }else{
                        $data = array(
                            'users_name'=>$this->input->post('name'),
                            'users_email'=>$this->input->post('email'),
                            'users_phone'=>$this->input->post('phone'),
                            'users_nip'=>$this->input->post('nip'),
                           
                        );
                        $this->model_app->update('users',$data,array('users_id'=>$id));
                        $status = true;
                        $msg = 'Data berhasil dirubah';
                    }
                }else{
                    $data = array(
                        'users_name'=>$this->input->post('name'),
                        'users_email'=>$this->input->post('email'),
                        'users_phone'=>$this->input->post('phone'),
                        'users_nip'=>$this->input->post('nip'),
                       
                    );
                    $this->model_app->update('users',$data,array('users_id'=>$id));
                    $status = true;
                    $msg = 'Data berhasil diubah!';
                }
                
                
            }else{
                $status = false;
                $msg = 'Users not found!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function updatePassword(){
        if($this->input->method() == 'post'){
            $url = null;
            $msg = null;
            $id = decode($this->session->userdata['internal']['id']);

            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[255]');			

                $this->form_validation->set_rules('repassword', 'Retype Password', 'required|matches[password]');
                    
                        
                
                if($this->form_validation->run() == FALSE){
                    $status = false;
                    $replace = array('<p>','</p>');
                    $msg = replace($replace,validation_errors());
                }else{
                    $data = array( 'users_password'=>$this->user_access->encrypt_md5($row['users_username'],$this->input->post('password')));
                    $this->model_app->update('users',$data,array('users_id'=>$row['users_id']));
                    $status = true;
                    $msg = 'Password berhasil diubah';
                }
            }else{
                $status= false;
                $msg = 'Users not found!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
}