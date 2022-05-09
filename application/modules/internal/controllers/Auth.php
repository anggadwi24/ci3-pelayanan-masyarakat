<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->model('model_app');
            $this->load->helper('base_helper');
           

        }
        
        public function index()
        {
            if($this->session->userdata('internal')){
                redirect('internal/dashboard');
            }else{
                $data['title'] = 'Internal Kelurahan Renon';
              
                // $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="#!">Table</a></li>';
                $data['js'] = base_url('template/admin/ajax/user/ajax-auth.js');
                $this->load->view('view_login',$data);
                
            }
           
        }
    
        public function doLogin()
        {
            if($this->input->method('post')){
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $msg = null;
                $conn = null;
                if($this->session->userdata('redirect') != null){
                    $redirect = $this->session->userdata('redirect');

                }else{
                    $redirect = base_url('internal/dashboard');

                }
                $cek = $this->model_app->dataUsers($email);
                
                if($cek->num_rows() > 0){
                    $pwd = $this->user_access->encrypt_md5($email,$password);
                    $row = $cek->row_array();
                    $pass = $row['users_password'];
                    if($pass == $pwd){
                        if($row['users_active'] == 'y'){
                            $status = true;

                            $sess = array('internal'=>array('id'=>encode($row['users_id']),'level'=>$row['users_level']));
                            $this->session->set_userdata($sess);
                            $this->session->set_flashdata('welcome','Selamat Datang '.$row['users_name']);
                        }else{
                            $status = false;
                            $msg = 'Akun anda tidak aktif!';
                            $conn = 1;
                        }   
                            
                    }else{
                        $status = false;
                        $msg = 'Password salah!';
                        $conn = 0;

                    }

                
                }else{
                    $status = false;
                    $msg = 'Akun tidak ditemukan!';
                    $conn = 1;

                }
                echo json_encode(array('status'=>$status,'msg'=>$msg,'redirect'=>$redirect,'conn'=>$conn));
            }else{
                $this->load->view('501');
            }
            
        }
    
        public function logout()
        {
            $this->session->sess_destroy();
            redirect(base_url("internal/auth"));
        }
    
}
?>