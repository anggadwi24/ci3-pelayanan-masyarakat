<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrasi extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();
        $this->id = decode($this->session->userdata['internal']['id']);
        $this->user = $this->model_app->view_where('users',array('users_id'=>$this->id))->row_array();
      

    }

    public function index() {
        __ceksess('internal/administrasi');

        $this->session->set_userdata(array('redirect'=>current_url()));
        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Pelayanan Masyarakat';
        $data['header'] = 'Data Pelayanan Masyarakat';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/administrasi').'">Pelayanan Masyarakat</a></li>';
        // $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="#!">Table</a></li>';
        $data['js'] = base_url('template/admin/ajax/administrasi/ajax-pm.js');
        $this->template->load('template','mod_pm/view_pm',$data);


        
    }
    public function add() {
        __ceksess('internal/administrasi/add');

        $this->session->set_userdata(array('redirect'=>current_url()));
        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Pelayanan Masyarakat';
        $data['header'] = 'Pengajuan Pelayanan Masyarakat';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/administrasi').'">Pelayanan Masyarakat</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Tambah</a></li>';
        $data['js'] = base_url('template/admin/ajax/administrasi/ajax-add.js');
        $this->template->load('template','mod_pm/view_add',$data);


    }
    function complete(){
        __ceksess('internal/administrasi/add');
        $id= decode($this->input->get('id'));
        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            if($row['pm_status'] == 'undone'){
                $data['row'] = $row;
                $this->session->set_userdata(array('redirect'=>current_url()));
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Pelayanan Masyarakat';
                $data['header'] = 'Detail Pelayanan Masyarakat';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/administrasi').'">Pelayanan Masyarakat</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Complete</a></li>';
                $data['js'] = base_url('template/admin/ajax/administrasi/ajax-complete.js');
                $data['sub'] = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']))->row_array();
                $data['pel'] = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$row['pm_pelayanan_id']))->row_array();
                $data['banjar'] = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                $data['temp'] = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();

                $this->template->load('template','mod_pm/view_complete',$data);
            }else{
                $this->session->set_flashdata('message','Pelayanan Masyarakat sudah dilengkapi');
                redirect('internal/administrasi');
            }
        }else{
            $this->session->set_flashdata('message','Pelayanan Masyarakat tidak ditemukan!');
            redirect('internal/administrasi');
        }
        

    }
    function detail(){
        __ceksess('internal/administrasi/detail');
        $id= decode($this->input->get('id'));
        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            if($row['pm_status'] != 'undone'){
                $data['row'] = $row;
                $this->session->set_userdata(array('redirect'=>current_url()));
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Pelayanan Masyarakat';
                $data['header'] = 'Detail Pelayanan Masyarakat';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/administrasi').'">Pelayanan Masyarakat</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Detail</a></li>';
                $data['js'] = base_url('template/admin/ajax/administrasi/ajax-detail.js');
                $data['sub'] = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']))->row_array();
                $data['pel'] = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$row['pm_pelayanan_id']))->row_array();
                $data['banjar'] = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                $data['temp'] = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();

                $this->template->load('template','mod_pm/view_detail',$data);
            }else{
                $this->session->set_flashdata('message','Pelayanan Masyarakat sudah dilengkapi');
                redirect('internal/administrasi');
            }
        }else{
            $this->session->set_flashdata('message','Pelayanan Masyarakat tidak ditemukan!');
            redirect('internal/administrasi');
        }
        

    }
    function pelayanan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $output .= "<option disabled selected></option>";

                $status = true;
                $msg = null;
                $data = $this->model_app->view_where_ordering('pelayanan',array('pelayanan_visible'=>'y'),'pelayanan_name','ASC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".encode($row['pelayanan_id'])."'>".$row['pelayanan_name']."</option>";
                    }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    
    function contentPelayanan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/administrasi/add');
            $content = null;
            if($status == 1){
                $id = decode($this->input->post('id'));
                $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
                if($cek->num_rows() > 0){
                    $row =$cek->row_array();
                    if($row['pm_status'] == 'undone'){
                        $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                            if($sub->num_rows() > 0){
                                $rows = $sub->row_array();
                                if (method_exists($this,$rows['subpel_link'])) {
                                    $status =true;
                                    $msg = null;
                                    $link = str_replace('"','',$rows['subpel_link']);
                                    $content = $this->$link();
                                } else {
                                    // if false
                                    $status = false;
                                    $msg = 'Method Not Found';
                                    $content = null;
                                }
                                
                            }else{
                                $status = false;
                                $msg ='Pelayanan tidak ditemukan';
                            }
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah dilengkapi';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan Masyarakat tidak ditemukan';
                }
                
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'content'=>$content));
        }else{
            $this->load->view('501');
        }
    }
    private function convertPelayanan($id){
        if($this->input->method() == 'get'){
            $status = __ceksesskonten('internal/administrasi/approve');
            $content = null;
            if($status == 1){
                // $id = decode($this->input->post('id'));
                $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
                if($cek->num_rows() > 0){
                    $row =$cek->row_array();
                    if($row['pm_status'] == 'done'){
                        $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                            if($sub->num_rows() > 0){
                                $rows = $sub->row_array();
                                $link = "convert_".str_replace('"','',$rows['subpel_link']);
                                if (method_exists($this,$link)) {
                                    $status =true;
                                    $msg = null;
                                  
                                    $content = $this->$link($row['pm_id']);
                                    

                                } else {
                                    // if false
                                    $status = false;
                                    $msg = 'Method Not Found';
                                    $content = null;
                                }
                                
                            }else{
                                $status = false;
                                $msg ='Pelayanan tidak ditemukan';
                            }
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah dilengkapi';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan Masyarakat tidak ditemukan';
                }
                
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            return $content;
        }else{
            $this->load->view('501');
        }
    }
    function detailPelayanan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/administrasi/add');
            $content = null;
            if($status == 1){
                $id = decode($this->input->post('id'));
                $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
                if($cek->num_rows() > 0){
                    $row =$cek->row_array();
                    if($row['pm_status'] != 'undone'){
                        $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                            if($sub->num_rows() > 0){
                                $rows = $sub->row_array();
                                if (method_exists($this,$rows['subpel_link'])) {
                                    $status =true;
                                    $msg = null;
                                    $link = "detail_".str_replace('"','',$rows['subpel_link']);
                                    $content = $this->$link($row['pm_id']);
                                } else {
                                    // if false
                                    $status = false;
                                    $msg = 'Method Not Found';
                                    $content = null;
                                }
                                
                            }else{
                                $status = false;
                                $msg ='Pelayanan tidak ditemukan';
                            }
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah dilengkapi';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan Masyarakat tidak ditemukan';
                }
                
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'content'=>$content));
        }else{
            $this->load->view('501');
        }
    }
    public function dataDetail(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $content = null;
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $status = true;
                $msg = null;
                $user = $this->model_app->view_where('users',array('users_id'=>decode($this->session->userdata['internal']['id'])))->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_status'] == 'proses'){
                    if($row['pm_approve_kaling'] == NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL ){
                        
                        if($user['users_level'] == 'kaling'  AND $a > 0 ){
                            $rowB = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                            if($rowB['banjar_kaling'] == $user['users_id']){
                                $content .= "<div class='col-12'>
                                                <button class='btn btn-success btn-icon btn-sm mr-2' id='btnAppKaling' data-id='".encode($row['pm_id'])."' title='Approve Kepala Lingkungan'><i class='feather icon-check-circle'></i></button>
                                                <button class='btn btn-danger btn-icon btn-sm mr-2' id='btnDisKaling' data-id='".encode($row['pm_id'])."' title='Disapprove Kepala Lingkungan'><i class='feather icon-x-circle'></i></button>

                                
                                            </div>";
                            }
                           
                        }else if($user['users_level'] == 'admin' AND $a > 0){
                            $content .= "<div class='col-12'>
                                                <button class='btn btn-success btn-icon btn-sm ' id='btnAppKaling' data-id='".encode($row['pm_id'])."' title='Approve Kepala Lingkungan'><i class='feather icon-check-circle'></i></button>
                                                <button class='btn btn-danger btn-icon btn-sm mr-2' id='btnDisKaling' data-id='".encode($row['pm_id'])."' title='Disapprove Kepala Lingkungan'><i class='feather icon-x-circle'></i></button>

                                            </div>";

                        }else{
                            $content .= "<div class='col-12'><h6>Menunggu persetujuan kepala lingkungan</h6></div>";
                        }
                        
                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                        $kaling = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_kaling']))->row_array();
                        $content .= "<div class='col-12'><h6>Disetujui Oleh : ".$kaling['users_name']." (Kepala Lingkungan) </h6></div>";
                        if($user['users_level'] == 'pegawai' AND $a > 0){
                            $content .= "<div class='col-12'>
                                            <button class='btn btn-success btn-icon btn-sm' id='btnAppPegawai' data-id='".encode($row['pm_id'])."' title='Approve Pegawai'><i class='feather icon-check-circle'></i></button>
                                            <button class='btn btn-danger btn-icon btn-sm' id='btnDisPegawai' data-id='".encode($row['pm_id'])."' title='Disapprove Pegawai'><i class='feather icon-x-circle'></i></button>

                                        </div>";
                        }else if($user['users_level'] == 'admin' AND $a > 0){
                            $content .= "<div class='col-12'>
                                        <button class='btn btn-success btn-icon btn-sm' id='btnAppPegawai' data-id='".encode($row['pm_id'])."' title='Approve Pegawai'><i class='feather icon-check-circle'></i></button>
                                        <button class='btn btn-danger btn-icon btn-sm' id='btnDisPegawai' data-id='".encode($row['pm_id'])."' title='Disapprove Pegawai'><i class='feather icon-x-circle'></i></button>
                                        </div>";
                        }else{
                            $content .= "<div class='col-12'><h6>Menunggu persetujuan pegawai</h6></div>";
                        }  
                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                        $kaling = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_kaling']))->row_array();
                        $content .= "<div class='col-12'><h6>Disetujui Oleh : ".$kaling['users_name']." (Kepala Lingkungan) </h6></div>";
                        $pegawai = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_pegawai']))->row_array();
                        $content .= "<div class='col-12'><h6>Disetujui Oleh : ".$pegawai['users_name']. " (Pegawai) </h6></div>";

                        if($user['users_level'] == 'lurah' AND $a > 0){
                            $content .= "<div class='col-12'>
                                            <button class='btn btn-success btn-icon btn-sm' id='btnAppLurah' data-id='".encode($row['pm_id'])."' title='Approve Lurah'><i class='feather icon-check-circle'></i></button>
                                            <button class='btn btn-danger btn-icon btn-sm' id='btnDisLurah' data-id='".encode($row['pm_id'])."' title='Disapprove Lurah'><i class='feather icon-x-circle'></i></button>

                                        </div>";
                        }else if($user['users_level'] == 'admin' AND $a > 0){
                                $content .= "<div class='col-12'>
                                            <button class='btn btn-success btn-icon btn-sm' id='btnAppLurah' data-id='".encode($row['pm_id'])."' title='Approve Lurah'><i class='feather icon-check-circle'></i></button>
                                            <button class='btn btn-danger btn-icon btn-sm' id='btnDisLurah' data-id='".encode($row['pm_id'])."' title='Disapprove Lurah'><i class='feather icon-x-circle'></i></button>

                                        </div>";

                        }else{
                            $content .= "<div class='col-12'><h6>Menunggu persetujuan lurah</h6></div>";
                        }  
                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] != NULL){
                        
                        $content .= "<div class='col-12'><h6>Pelayanan sudah disetujui</h6></div>";
                    }
                  
                }else if($row['pm_status'] == 'cancel'){
                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL ){
                        $kaling = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_kaling']))->row_array();
                        $content .= "<div class='col-12'><h6>Pelayanan dibatalkan oleh ".$kaling['users_name']." (Kepala Lingkungan)</h6></div>";
                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                        
                        $pegawai = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_pegawai']))->row_array();
                        $content .= "<div class='col-12'><h6>Pelayanan dibatalkan oleh ".$pegawai['users_name']. " (Pegawai) </h6></div>";
                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] != NULL){
                        
                        $lurah = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_lurah']))->row_array();
                        $content .= "<div class='col-12'><h6>Pelayanan dibatalkan oleh ".$lurah['users_name']. " (Lurah) </h6></div>";
                    }
                }else if($row['pm_status'] == 'done'){
                    $kaling = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_kaling']))->row_array();
                    $content .= "<div class='col-12'><h6>Disetujui Oleh : ".$kaling['users_name']." (Kepala Lingkungan) </h6></div>";
                    $pegawai = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_pegawai']))->row_array();
                    $content .= "<div class='col-12'><h6>Disetujui Oleh : ".$pegawai['users_name']. " (Pegawai) </h6></div>";
                    $lurah = $this->model_app->view_where('users',array('users_id'=>$row['pm_approve_lurah']))->row_array();
                    $content .= "<div class='col-12 mb-3'><h6>Disetujui Oleh : ".$lurah['users_name']. " (Lurah) </h6></div>";
                    $download = base_url('internal/download?file='.encode($row['pm_id'].'_'.$row['pm_document']));
                    $content .= "<div class='col-12 form-group'><h6 class=''>Download : <a href='".$download."' target='_BLANK'><i class='fas fa-file-pdf'></i> #".$row['pm_no']."</a></h6></div>";
                   
                    $content .= "<div class='col-12 form-group'><h6 class=''>Status : ".ucfirst($row['pm_status'])."</h6></div>";
                    $content .= "<div class='col-12 form-group'><h6 class=''>Created on : ".date('d/m/y H:i',strtotime($row['pm_date']))."</h6></div>";

                    
                }else{
                    $content .= "<div class='col-12 form-group'><h6 class=''>Status : ".ucfirst($row['pm_status'])."</h6></div>";
                    $content .= "<div class='col-12 form-group'><h6 class=''>Created on : ".date('d/m/y H:i',strtotime($row['pm_date']))."</h6></div>";
                }
            }else{
                $status = false;
                $msg = 'Pelayanan tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'content'=>$content));
        }else{
            $this->load->view('501');
        }
    }
    function approveLurah(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_status'] == 'proses'){
                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                        if($a > 0){
                            $level = $this->session->userdata['internal']['level'];
                            
                            $us = decode($this->session->userdata['internal']['id']);
                            $user = $this->model_app->view_where('users',array('users_id'=>$us))->row_array();
                            if( $level == 'lurah' OR $level =='admin'  ){
                                $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                                if($sub->num_rows() > 0){
                                    $rows = $sub->row_array();
                                    $link = "convert_".str_replace('"','',$rows['subpel_link']);
                                    if (method_exists($this,$link)) {
                                        $data = array(
                                            'pm_approve_lurah' => decode($this->session->userdata['internal']['id']),
                                            'pm_status'=>'done',
                                        
                                        );
                                        $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                        $status = true;
                                        $content = $this->$link($row['pm_id']);
                                        if($content != ""){
                                            $fileName = 'PELAYANAN #'.$row['pm_no'].'.pdf';
                                            $this->approveHistory($row['pm_id'],'approve','lurah');
                                            $banjar= $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                                            $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                                        
                    
                                            $title = 'Pelayanan No. #'.$row['pm_no'];
                                            $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah ditolak oleh Lurah';
                                            $link = base_url().'internal/administrasi/detail?id='.encode($id);
        
                                            $html = "<span>Pelayanan dengan Nomor #".$row['pm_no']." telah disetujui</span><br> terima kasih telah menggunakan pelayanan kami<br><br> Sehat selalu, salam sejahtera <br></br> TTD <br>Kelurahan Renon" ;
                                            pushEmailAttach($row['pm_email'],$title,$html,$content,$fileName);
                                            $html = "Pelayaanan #".$row['pm_no']." telah disetujui oleh ".$this->user['users_name']." (lurah)<br><br>Nama : ".$temp['temp_fullname']." <br>NIK : ".$temp['temp_nik']." <br>Banjar : ".$banjar['banjar_name']."<br><br> Pelayanan selesai";
                                            pushTelegram($html);
                                            pushNotification('lurah',$title,$desc,$link,'y','internal/administrasi/approve',null);
                                            
                                            $msg = 'Berhasil menyetujui pelayanan!';
                                        }else{
                                           
                                            $msg = 'Beerhasil menyetujui pelayanan, tetapi gagal mengirim email ';
                                        }
                                       
                                        

                                    } else {
                                        // if false
                                        $status = false;
                                        $msg = 'Method Not Found';
                                     
                                    }
                                    
                                }else{
                                    $status = false;
                                    $msg ='Pelayanan tidak ditemukan';
                                }
                                   
                                
                                
                            }else{
                                $status = false;
                                $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                            }
                           
                        }else{
                            $status = false;
                            $msg = 'Unauthorized Access!';
                        }
                        
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah disetujui!';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan tidak dalam status proses';
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
    
    function disapproveLurah(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_status'] == 'proses'){
                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                        if($a > 0){
                            $level = $this->session->userdata['internal']['level'];
                            
                            $us = decode($this->session->userdata['internal']['id']);
                            $user = $this->model_app->view_where('users',array('users_id'=>$us))->row_array();
                            if( $level == 'lurah' OR $level =='admin'  ){
                               
                                    $data = array(
                                        'pm_approve_lurah' => decode($this->session->userdata['internal']['id']),
                                        'pm_status'=>'cancel',
                                    
                                    );
                                    $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                    $status = true;
                                    $this->approveHistory($row['pm_id'],'disapprove','lurah');
                                    
            
                                    $title = 'Pelayanan No. #'.$row['pm_no'];
                                    $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah ditolak oleh Lurah';
                                    $link = base_url().'internal/administrasi/detail?id='.encode($id);

                                    $html = "<h3>Pelayanan dengan Nomor #".$row['pm_no']." telah dibatalkan, untuk konfirmasi selanjutnya silahkan hubungi pihak Kelurahan</h3>" ;
                                    pushEmail($row['pm_email'],$title,$html);
                                    $html = "Pelayaanan #".$row['pm_no']." telah ditolak oleh ".$this->user['users_name']." (lurah)<br>";
                                    pushTelegram($html);
                                   
                                    pushNotification('lurah',$title,$desc,$link,'n','internal/administrasi/approve',null);
                                    
                                    $msg = 'Berhasil menolak pelayanan!';
                                
                                
                            }else{
                                $status = false;
                                $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                            }
                           
                        }else{
                            $status = false;
                            $msg = 'Unauthorized Access!';
                        }
                        
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah disetujui!';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan tidak dalam status proses';
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
    function approvePegawai(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_status'] == 'proses'){
                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                        if($a > 0){
                            $level = $this->session->userdata['internal']['level'];
                            $banjar= $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                            $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                            $us = decode($this->session->userdata['internal']['id']);
                            if( $level == 'pegawai' OR $level =='admin'  ){
                                
                                    $data = array(
                                        'pm_approve_pegawai' => decode($this->session->userdata['internal']['id']),
                                    
                                    );
                                    $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                    $status = true;
                                    $this->approveHistory($row['pm_id'],'approve','pegawai');
                                    
            
                                    $title = 'Pelayanan No. #'.$row['pm_no'];
                                    $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah disetujui oleh Pegawai';
                                    $link = base_url().'internal/administrasi/detail?id='.encode($id);
                                
                                    $html = "<h3>Pelayaanan dengan nomor #".$row['pm_no']." telah diajukan, silahkan menyetujui atau menolaknya</h3> <br> <a href='".$link."' class='btn btn-primary'>Lihat Detail</a>";
                                    pushNotification('lurah',$title,$desc,$link,'y','internal/administrasi/approve',null);
                                    $html = "Pelayaanan #".$row['pm_no']." telah disetujui oleh ".$this->user['users_name']." (lurah)<br><br>Nama : ".$temp['temp_fullname']." <br>NIK : ".$temp['temp_nik']." <br>Banjar : ".$banjar['banjar_name']."<br><br>silahkan untuk pegawai menyetujui atau menolaknya <br><br> Detail : $link";
                                    pushTelegram($html);
                                    $msg = 'Berhasil menyetujui pelayanan!';
                                
                                
                            }else{
                                $status = false;
                                $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                            }
                           
                        }else{
                            $status = false;
                            $msg = 'Unauthorized Access!';
                        }
                        
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah disetujui!';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan tidak dalam status proses';
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
   
    function disapprovePegawai(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_status'] == 'proses'){
                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                        if($a > 0){
                            $level = $this->session->userdata['internal']['level'];
                            
                            $us = decode($this->session->userdata['internal']['id']);
                            $user = $this->model_app->view_where('users',array('users_id'=>$us))->row_array();
                            if( $level == 'pegawai' OR $level =='admin'  ){
                               
                                    $data = array(
                                        'pm_approve_pegawai' => decode($this->session->userdata['internal']['id']),
                                        'pm_status'=>'cancel',
                                    
                                    );
                                    $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                    $status = true;
                                
                                    $this->approveHistory($row['pm_id'],'disapprove','pegawai');
                                    
                                    $title = 'Pelayanan No. #'.$row['pm_no'];
                                    $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah ditolak oleh '.$user['users_name'].'(Pegawai)';
                                    $link = base_url().'internal/administrasi/detail?id='.encode($id);
                                
                                    $html = "<h3>Pelayanan dengan Nomor #".$row['pm_no']." telah dibatalkan, untuk konfirmasi selanjutnya silahkan hubungi pihak Kelurahan</h3>" ;
                                    pushEmail($row['pm_email'],$title,$html);
                                    pushNotification('lurah',$title,$desc,$link,'n','internal/administrasi/approve',null);
                                    $html1 = "Pelayaanan #".$row['pm_no']." telah ditolak oleh ".$this->user['users_name']." (pegawai)<br>";
                                    pushTelegram($html1);
                                    $msg = 'Berhasil menolak pelayanan!';
                                
                                
                            }else{
                                $status = false;
                                $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                            }
                           
                        }else{
                            $status = false;
                            $msg = 'Unauthorized Access!';
                        }
                        
                    }else{
                        $status = false;
                        $msg = 'Pelayanan sudah disetujui!';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan tidak dalam status proses';
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
    function approveKaling(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_approve_kaling'] == NULL ){
                    if($a > 0){
                        $level = $this->session->userdata['internal']['level'];
                        $banjar= $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                        

                        $us = decode($this->session->userdata['internal']['id']);
                        $user = $this->model_app->view_where('users',array('users_id'=>$us))->row_array();
                        if( $level == 'kaling' OR $level =='admin'  ){
                            if($level == 'kaling' AND $us != $banjar['banjar_kaling']){
                                $status = false;
                                $msg =' Anda tidak bisa menyetujui pelayanan pada banjar lain!';
                            }else{
                                $data = array(
                                    'pm_approve_kaling' => decode($this->session->userdata['internal']['id']),
                                
                                );
                                $this->approveHistory($row['pm_id'],'approve','kaling');

                                $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                $status = true;
                            
                                $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                                
                                $title = 'Pelayanan No. #'.$row['pm_no'];
                                $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah disetujui oleh Kepala Lingkungan';
                                $link = base_url().'internal/administrasi/detail?id='.encode($id);
                            
                                $html = "<h3>Pelayaanan dengan nomor #".$row['pm_no']." telah diajukan, silahkan menyetujui atau menolaknya</h3> <br> <a href='".$link."' class='btn btn-primary'>Lihat Detail</a>";
                                pushNotification('lurah',$title,$desc,$link,'y','internal/administrasi/approve',null);
                                $html = "Pelayaanan #".$row['pm_no']." telah disetujui oleh ".$user['users_name']." (kepala lingkungan)<br><br>Nama : ".$temp['temp_fullname']." <br>NIK : ".$temp['temp_nik']." <br>Banjar : ".$banjar['banjar_name']."<br><br>silahkan untuk pegawai menyetujui atau menolaknya <br><br> Detail : $link";
                                pushTelegram($html);
                                // $usersPush = $this->db->query("SELECT * FROM users a JOIN users_modul b ON a.users_id = b.umod_users_id JOIN submodul c ON b.umod_submodul_id = c.submodul_id WHERE users_level = 'pegawai' AND users_active = 'y' AND submodul_link = 'internal/administrasi/approve'");
                                // if($usersPush->num_rows() > 0){
                                //     foreach($usersPush->result_array() as $usRow){
                                //     pushEmail($usRow['users_email'],$title,$html);
                                //     }
                                // }
                                $msg = 'Berhasil menyetujui pelayanan!';
                            }
                            
                        }else{
                            $status = false;
                            $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Unauthorized Access!';
                    }
                    
                }else{
                    $status = false;
                    $msg = 'Pelayanan sudah disetujui!';
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
    
    function disapproveKaling(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $a = __ceksesskonten('internal/administrasi/approve');
                if($row['pm_approve_kaling'] == NULL ){
                    if($a > 0){
                        $level = $this->session->userdata['internal']['level'];
                        if( $level == 'kaling' OR $level =='admin' ){
                            $banjar= $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                            $us = decode($this->session->userdata['internal']['id']);
                            
                            if($level == 'kaling' AND $us != $banjar['banjar_kaling']){
                                $status = false;
                                $msg =' Anda tidak bisa menyetujui pelayanan pada banjar lain!';
                            }else{
                                $data = array(
                                    'pm_approve_kaling' => decode($this->session->userdata['internal']['id']),
                                    'pm_status'=>'cancel',
                                
                                );
                                $this->model_app->update('pelayanan_masyarakat',$data,array('pm_id'=>$id));
                                $status = true;
                            
                                $this->approveHistory($row['pm_id'],'disapprove','kaling');
    
                                $title = 'Pelayanan No. #'.$row['pm_no'];
                                $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah dibatalkan oleh Kepala Lingkungan';
                                $link = base_url().'internal/administrasi/detail?id='.encode($id);
                                $html = "<h3>Pelayanan dengan Nomor #".$row['pm_no']." telah dibatalkan, untuk konfirmasi/informasi selanjutnya silahkan hubungi pihak Kelurahan</h3>" ;
                                pushEmail($row['pm_email'],$title,$html);
                                $html1 = "Pelayaanan #".$row['pm_no']." telah ditolak oleh ".$this->user['users_name']." (kepala lingkungan)<br>";
                                pushTelegram($html1);
                                pushNotification('lurah',$title,$desc,$link,'n','internal/administrasi/approve',null);
                                
                                $msg = 'Berhasil menolak pelayanan!';
                            }
                            
                        }else{
                            $status = false;
                            $msg = 'Anda tidak memiliki akses untuk menyetujui pelayanan!';
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Unauthorized Access!';
                    }
                    
                }else{
                    $status = false;
                    $msg = 'Pelayanan sudah disetujui!';
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
    private function approveHistory($pm_id,$action,$level){
        $data = array(
            'pmh_pm_id'=>$pm_id,
            'pmh_level'=>$level,
            'pmh_action'=>$action,
            'pmh_date'=>date('Y-m-d H:i:s'),
            'pmh_users_id'=>$this->user['users_id'],
        );
        $this->model_app->insert('pelayanan_masyarakat_history',$data);
    }
    private function add_surat_keterangan_usaha($post){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>decode($post['id']),'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_alamat_usaha'=>$post['alamat_usaha']);
            $this->model_app->insert('surat_keterangan_usaha',$data);
            return true;
        }else{
            return false;
        }
    }
    private function add_surat_keterangan_domisili_usaha($post){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>decode($post['id']),'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_alamat_usaha'=>$post['alamat_usaha']);
            $sku_id = $this->model_app->insert_id('surat_keterangan_usaha',$data);
            $data1 = array('skdu_sku_id'=>$sku_id,'skdu_keperluan'=>$post['keperluan'],'skdu_pm_id'=>decode($post['id']));
            $this->model_app->insert('surat_keterangan_domisili_usaha',$data1);
            return true;
        }else{
            return false;
        }
    }
    private function add_surat_keterangan_usaha_tidak_berjalan($post){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>decode($post['id']),'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_status'=>'n','sku_alamat_usaha'=>$post['alamat_usaha']);
            $sku_id = $this->model_app->insert_id('surat_keterangan_usaha',$data);
            $data1 = array('skutb_sku_id'=>$sku_id,'skutb_tanggal_berhenti'=>date('Y-m-d',strtotime($post['tanggal_berhenti'])),'skutb_pm_id'=>decode($post['id']));
            $this->model_app->insert('surat_keterangan_usaha_tidak_berjalan',$data1);
            return true;
        }else{
            return false;
        }
    }

    private function detail_surat_keterangan_usaha_tidak_berjalan($id){
        $cek = $this->model_app->view_where('surat_keterangan_usaha_tidak_berjalan',array('skutb_pm_id'=>$id));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            $usaha = $this->model_app->view_where('surat_keterangan_usaha',array('sku_id'=>$row['skutb_sku_id']))->row_array();
            $output .= "<div class='col-12 form-group'>
                            <label>Nama Usaha</label>
                            <h6>".$usaha['sku_nama_usaha']."</h6>
                        </div>
                        <div class='col-12 form-group'>
                            <label>Jenis Usaha</label>
                            <h6>".$usaha['sku_jenis_usaha']."</h6>
                        </div>
                        <div class='col-6 form-group'>
                            <label>Tanggal Berdiri</label>
                            <h6>".tanggal($usaha['sku_tanggal_berdiri'])."</h6>
                        </div>
                       
                        <div class='col-6 form-group'>
                            <label>Tanggal Berhenti</label>
                            <h6>".tanggal($row['skutb_tanggal_berhenti'])."</h6>
                        </div>
                        <div class='col-12 form-group' >
                            <label>Alamat Usaha</label>
                            <h6>".$usaha['sku_alamat_usaha']."</h6>
                        </div>
                       
                        ";
            return $output;
        }else{
            return false;
        }
    }
    private function detail_surat_keterangan_domisili_usaha($id){
        $cek = $this->model_app->view_where('surat_keterangan_domisili_usaha',array('skdu_pm_id'=>$id));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            $usaha = $this->model_app->view_where('surat_keterangan_usaha',array('sku_id'=>$row['skdu_sku_id']))->row_array();
            $output .= "<div class='col-8 form-group'>
                            <label>Nama Usaha</label>
                            <h6>".$usaha['sku_nama_usaha']."</h6>
                        </div>
                        <div class='col-4 form-group'>
                            <label>Jenis Usaha</label>
                            <h6>".$usaha['sku_jenis_usaha']."</h6>
                        </div>
                        <div class='col-12 form-group'>
                            <label>Tanggal Berdiri</label>
                            <h6>".tanggal($usaha['sku_tanggal_berdiri'])."</h6>
                        </div>
                        <div class='col-12 form-group' >
                            <label>Alamat Usaha</label>
                            <h6>".$usaha['sku_alamat_usaha']."</h6>
                        </div>
                        <div class='col-12 form-group'>
                            <label>Keperluan</label>
                            <h6>".$row['skdu_keperluan']."</h6>
                        </div>
                       
                        ";
            return $output;
        }else{
            return false;
        }
    }
    private function detail_surat_keterangan_usaha($id){
        $cek = $this->model_app->view_where('surat_keterangan_usaha',array('sku_pm_id'=>$id));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
          
            $output .= "<div class='col-8 form-group'>
                            <label>Nama Usaha</label>
                            <h6>".$row['sku_nama_usaha']."</h6>
                        </div>
                        <div class='col-4 form-group'>
                            <label>Jenis Usaha</label>
                            <h6>".$row['sku_jenis_usaha']."</h6>
                        </div>
                        <div class='col-12 form-group'>
                            <label>Tanggal Berdiri</label>
                            <h6>".tanggal($row['sku_tanggal_berdiri'])."</h6>
                        </div>
                        <div class='col-12 form-group' >
                            <label>Alamat Usaha</label>
                            <h6>".$row['sku_alamat_usaha']."</h6>
                        </div>
                        <div class='col-12 form-group'>
                            <label>Keperluan</label>
                            <h6>".$row['sku_keperluan']."</h6>
                        </div>
                       
                        ";
            return $output;
        }else{
            return false;
        }
    }

    private function convert_surat_keterangan_usaha($id){
        $cek = $this->model_app->join_where('pelayanan_masyarakat','masyarakat_temp','pm_temp_id','temp_id',array('pm_id'=>$id,'pm_status'=>'done'));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            $pel = $this->model_app->view_where('surat_keterangan_usaha',array('sku_pm_id'=>$row['pm_id']));
            if($pel->num_rows() > 0){
                $data['row'] = $row;
                $data['rows'] = $pel->row_array();
                $data['job'] = $this->model_app->view_where('jenis_pekerjaan',array('jp_id'=>$row['temp_job']))->row_array();
                $html = $this->load->view('mod_surat/surat_keterangan_usaha',$data,true);
               
                $filename = 'PELAYANAN NO #'.$row['pm_no'];
                $paper = 'A4';
                $orientation = 'potrait';
                $attachName = $filename.'.pdf';

                $attach = pdf_create($html, $filename, $paper, $orientation,false);
                if(file_exists('./upload/document/'.$attachName)){
                    unlink('./upload/document/'.$attachName);
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }else{
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }
                $this->model_app->update('pelayanan_masyarakat',array('pm_document'=>$attachName),array('pm_id'=>$row['pm_id']));
                return $attach;
            }else{
                return false;
            }
            
           
        }else{
            return false;
        }
    }
    private function convert_surat_keterangan_domisili_usaha($id){
        $cek = $this->model_app->join_where('pelayanan_masyarakat','masyarakat_temp','pm_temp_id','temp_id',array('pm_id'=>$id,'pm_status'=>'done'));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            $pel = $this->model_app->view_where('surat_keterangan_domisili_usaha',array('skdu_pm_id'=>$row['pm_id']));
            if($pel->num_rows() > 0){
                $data['row'] = $row;
                
                $pRow= $pel->row_array();
                $data['rows'] = $pel->row_array();
                $usaha = $this->model_app->view_where('surat_keterangan_usaha',array('sku_id'=>$pRow['skdu_sku_id']));
                $data['usaha']=$usaha->row_array();
                $data['job'] = $this->model_app->view_where('jenis_pekerjaan',array('jp_id'=>$row['temp_job']))->row_array();
                $html = $this->load->view('mod_surat/surat_keterangan_domisili_usaha',$data,true);
               
                $filename = 'PELAYANAN NO #'.$row['pm_no'];
                $paper = 'A4';
                $orientation = 'potrait';
                $attachName = $filename.'.pdf';

                $attach = pdf_create($html, $filename, $paper, $orientation,false);
                if(file_exists('./upload/document/'.$attachName)){
                    unlink('./upload/document/'.$attachName);
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }else{
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }
                $this->model_app->update('pelayanan_masyarakat',array('pm_document'=>$attachName),array('pm_id'=>$row['pm_id']));
                return $attach;
            }else{
                return false;
            }
            
           
        }else{
            return false;
        }
    }
    private function convert_keterangan_usaha_tidak_berjalan($id){
        $cek = $this->model_app->join_where('pelayanan_masyarakat','masyarakat_temp','pm_temp_id','temp_id',array('pm_id'=>$id,'pm_status'=>'done'));
        $output = null;
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            $pel = $this->model_app->view_where('surat_keterangan_usaha_tidak_berjalan',array('skutb_pm_id'=>$row['pm_id']));
            if($pel->num_rows() > 0){
                $data['row'] = $row;
                $pRow= $pel->row_array();
                $data['rows'] = $pel->row_array();
                $usaha = $this->model_app->view_where('surat_keterangan_usaha',array('sku_id'=>$pRow['skdu_sku_id']));
                $data['usaha']=$usaha->row_array();

                $data['job'] = $this->model_app->view_where('jenis_pekerjaan',array('jp_id'=>$row['temp_job']))->row_array();
                $html = $this->load->view('mod_surat/surat_keterangan_usaha_tidak_berjalan',$data,true);
               
                $filename = 'PELAYANAN NO #'.$row['pm_no'];
                $paper = 'A4';
                $orientation = 'potrait';
                $attachName = $filename.'.pdf';

                $attach = pdf_create($html, $filename, $paper, $orientation,false);
                if(file_exists('./upload/document/'.$attachName)){
                    unlink('./upload/document/'.$attachName);
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }else{
                    file_put_contents('./upload/document/'.$attachName, $attach);
                }
                $this->model_app->update('pelayanan_masyarakat',array('pm_document'=>$attachName),array('pm_id'=>$row['pm_id']));
                return $attach;
            }else{
                return false;
            }
            
           
        }else{
            return false;
        }
    }
    private function surat_keterangan_usaha_tidak_berjalan(){
        $output = '
                   
        <div class="col-8 form-group">
            <label>Nama Usaha</label>
            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
        </div>
        <div class="col-4 form-group">
            <label>Jenis Usaha</label>
            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
        </div>
        <div class="col-12 form-group">
            <label>Alamat Usaha</label>
            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
        </div>
        <div class="col-6 form-group">
            <label>Tanggal Berdiri</label>
            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
        </div>
        <div class="col-6 form-group">
            <label>Tanggal Berhenti</label>
            <input type="date" name="tanggal_berhenti" id="tanggal_berhenti" class="form-control" required >
        </div>
        <div class="col-12 form-group">
            <label>Keperluan</label>
            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
        </div>

     ';
    return $output;
    }
    private function surat_keterangan_usaha(){
        $output = '
                   
                        <div class="col-8 form-group">
                            <label>Nama Usaha</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                            <label>Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
                        </div>
                        <div class="col-8 form-group">
                            <label>Alamat Usaha</label>
                            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                            <label>Tanggal Berdiri</label>
                            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
                        </div>
                        <div class="col-12 form-group">
                            <label>Keperluan</label>
                            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
                        </div>

                     ';
        return $output;
    }
    private function surat_keterangan_domisili_usaha(){
        $output = '
                   
                        <div class="col-8 form-group">
                            <label>Nama Usaha</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                            <label>Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
                        </div>
                        <div class="col-8 form-group">
                            <label>Alamat Usaha</label>
                            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                            <label>Tanggal Berdiri</label>
                            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
                        </div>
                        <div class="col-12 form-group">
                            <label>Keperluan</label>
                            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
                        </div>

                     ';
        return $output;
    }
 
    function storeComplete(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/administrasi/add');
            $redirect = null;
            if($status == 1){
                $id = decode($this->input->post('id'));
                $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
                if($cek->num_rows() > 0){
                    $row =$cek->row_array();
                    if($row['pm_status'] == 'undone'){
                        $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                            if($sub->num_rows() > 0){
                                $rows = $sub->row_array();
                                if (method_exists($this,$rows['subpel_link'])) {
                                    // $status =true;
                                    $msg = null;
                                    $link = 'add_'.str_replace('"','',$rows['subpel_link']);
                                    $content = $this->$link($this->input->post());
                                    if($content == true){
                                        $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                                        $this->model_app->update('pelayanan_masyarakat',array('pm_status'=>'proses'),array('pm_id'=>$id));
                                        $status = true;
                                        $msg = 'Pengajuan berhasil diselesaikan';
                                        $redirect = base_url('internal/administrasi');
                                        $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                                        $kaling = $this->model_app->view_where('users',array('users_id'=>$banjar['banjar_kaling']))->row_array();
                                        $title = 'Pelayanan No. #'.$row['pm_no'];
                                        $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah diajukan, silahkan menyetujui atau menolaknya';
                                        $link = base_url().'internal/administrasi/detail?id='.encode($id);
                                        $html = "Pelayaanan #".$row['pm_no']." telah diajukan<br><br>Nama : ".$temp['temp_fullname']." <br>NIK : ".$temp['temp_nik']." <br>Banjar : ".$banjar['banjar_name']."<br><br>silahkan untuk kepala lingkungan terkait menyetujui atau menolaknya <br><br> Detail : $link";
                                        pushNotification('kaling',$title,$desc,$link,'n','internal/administrasi/approve',$banjar['banjar_kaling']);
                                        
                                        pushTelegram($html);
                                    }else{
                                        $status= false;
                                        $msg ='Terjadi kesalahan';
                                    }
                                } else {
                                    // if false
                                    $status = false;
                                    $msg = 'Method Not Found';
                                    $content = null;
                                }
                                
                            }else{
                                $status = false;
                                $msg ='Pelayanan tidak ditemukan';
                            }
                    }else{
                        $status = false;
                        $msg = 'Pelayanan Masyarakat sudah dilengkapi';
                    }
                }else{
                    $status = false;
                    $msg = 'Pelayanan Masyarakat tidak ditemukan';
                }
                
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'redirect'=>$redirect));
        }else{
            $this->load->view('501');
        }
    }
    function store(){
        if($this->input->method() == 'post'){
            $redirect = null;
            $this->form_validation->set_rules('no_pengajuan','Nomor Pengajuan','required|is_unique[pelayanan_masyarakat.pm_no]');
            $config['upload_path']          = './upload/identity/';
            $config['allowed_types']        = 'gif|jpg|png';
        
            $config['encrypt_name'] = TRUE;
        
            $config['max_size']             = 50000;
            $this->load->library('upload', $config);

            if($this->form_validation->run() === FALSE){
                $status = false;
                $msg = validation_errors();
            }elseif(!$this->upload->do_upload('file')){
                $status = false;
                $msg = $this->upload->display_errors();
            }else{
                $upload_data = $this->upload->data();
                $identity = $upload_data['file_name'];
                $pelayanan = decode($this->input->post('pelayanan'));
                $sub_pelayanan = decode($this->input->post('sub_pelayanan'));
                $banjar = decode($this->input->post('banjar'));
                $pm_no = $this->input->post('no_pengajuan');
                $cekPelayanan = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$pelayanan));
                if($cekPelayanan->num_rows() > 0){
                    $cekSub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$sub_pelayanan));
                    if($cekSub->num_rows() > 0){
                        $cekBanjar = $this->model_app->view_where('banjar',array('banjar_id'=>$banjar));
                        if($cekBanjar->num_rows() > 0){
                            $rowBanjar = $cekBanjar->row_array();
                            if($rowBanjar['banjar_kaling'] != NULL){
                                $rowSub = $cekSub->row_array();
                                $nik = $this->input->post('nik');
                                $fullname = $this->input->post('fullname');
                                $gender = $this->input->post('gender');
                                $religion = $this->input->post('religion');
                                $pob = $this->input->post('pob');
                                $dob = $this->input->post('dob');
                                $job = decode($this->input->post('job'));
                                $country = $this->input->post('country');
                                $prov = $this->input->post('province');
                                $kab = $this->input->post('kabupaten');
                                $kec = $this->input->post('kecamatan');
                                $kel = $this->input->post('kelurahan');
                                $add = $this->input->post('address');
                
                                $dataTemp = array('temp_nik'=>$nik,
                                                  'temp_fullname'=>$fullname,
                                                  'temp_gender'=>$gender,
                                                  'temp_pob'=>$pob,
                                                  'temp_dob'=>date('Y-m-d',strtotime($dob)),
                                                  'temp_religion'=>$religion,
                                                  'temp_nationality'=>$country,
                                                  'temp_job'=>$job,
                                                  'temp_address'=>$add,
                                                  'temp_prov'=>$prov,
                                                  'temp_kab'=>$kab,
                                                  'temp_kec'=>$kec,
                                                  'temp_kel'=>$kel,
                                                );
                                $temp_id = $this->model_app->insert_id('masyarakat_temp',$dataTemp);
                                $dataPM = array('pm_no'=>$pm_no,
                                                'pm_pelayanan_id'=>$pelayanan,  
                                                'pm_subpel_id'=>$sub_pelayanan,
                                                'pm_temp_id'=>$temp_id,
                                                'pm_banjar_id'=>$banjar,
                                                'pm_email'=>$this->input->post('email'),
                                                'pm_status'=>'undone',
                                                'pm_date'=>date('Y-m-d H:i:s'),
                                                'pm_identity'=>$identity,
                                                'pm_created_by'=>decode($this->session->userdata['internal']['id']),
                                            );
                                $pm_id = $this->model_app->insert_id('pelayanan_masyarakat',$dataPM);
                                $status = true;
                                $msg = 'Data pemohon berhasil ditambah';
                                $redirect = base_url('internal/administrasi/complete?id='.encode($pm_id));
                                
                            }else{
                                $status = false;
                                $msg = 'Banjar belum memiliki kepala lingkungan';
                            }
                        }else{
                            $status = false;
                            $msg = 'Banjar tidak ditemukan';
                        }
                    }else{  
                        $status = false;
                        $msg = 'Sub Pelayanan tidak ditemukan';
                    }
                }else{
                    $status =false;
                    $msg = 'Pelayanan tidak ditemukan';
                }
                
               


            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'redirect'=>$redirect));

        }else{
            $this->load->view('501');
        }
    }
    function subPelayanan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $id = decode($this->input->post('id'));
                $cek = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$id));
                if($cek->num_rows() > 0){
                    $status = true;
                    $msg = null;
                    $output .= "<option disabled selected></option>";

                    $data = $this->model_app->view_where_ordering('sub_pelayanan',array('subpel_visible'=>'y','subpel_pelayanan_id'=>$id),'subpel_name','ASC');
                    if($data->num_rows() > 0){
                        foreach($data->result_array() as $row){
                            $output .= "<option value='".encode($row['subpel_id'])."'>".$row['subpel_name']."</option>";
                        }
                    }else{
                        $status = false;
                        $msg = 'Tidak ada sub pelayanan';
                    }
                }else{
                    $status = false;
                    $msg ='Pelayanan tidak ditemukan';
                }
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function banjar(){
       
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $output .= "<option disabled selected></option>";
                $status = true;
                
                $msg = null;
                $data = $this->model_app->view_where_ordering('banjar',array('banjar_kaling !='=>NULL),'banjar_name','ASC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".encode($row['banjar_id'])."'>".$row['banjar_name']."</option>";
                    }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
        
    }

    function province(){
       
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $output .= "<option disabled selected></option>";
                $status = true;
                
                $msg = null;
                $data = $this->model_app->view_order('provinsi','prov_name','ASC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        // if($row['neg_name'] == 'Indonesia'){
                        //     $output .= "<option value='".$row['neg_name']."' selected>".$row['neg_name']."</option>";
                        // }else{
                        //     $output .= "<option value='".$row['neg_name']."'>".$row['neg_name']."</option>";
                        // }
                        $output .= "<option value='".$row['prov_id']."'>".$row['prov_name']."</option>";
                    }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
        
    }
    function kabupaten(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $id = $this->input->post('id');
               

                $data = $this->model_app->view_where_ordering('kabupaten',array('kab_prov_id'=>$id),'kab_name','ASC');
                if($data->num_rows() > 0){
                    $output .= "<option disabled selected></option>";
                    $status = true;
                    $msg = null;
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".$row['kab_id']."'>".$row['kab_name']."</option>";
                    }
                }else{
                    $status = false;
                    $msg = 'Tidak ada kabupaten';
                }
               
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function kecamatan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $id = $this->input->post('id');
               

                $data = $this->model_app->view_where_ordering('kecamatan',array('kec_kab_id'=>$id),'kec_name','ASC');
                if($data->num_rows() > 0){
                    $output .= "<option disabled selected></option>";
                    $status = true;
                    $msg = null;
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".$row['kec_id']."'>".$row['kec_name']."</option>";
                    }
                }else{
                    $status = false;
                    $msg = 'Tidak ada kecamatan';
                }
               
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function kelurahan(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $id = $this->input->post('id');
               
               
                $data = $this->model_app->view_where_ordering('kelurahan',array('kel_kec_id'=>$id),'kel_name','ASC');
                if($data->num_rows() > 0){
                    $output .= "<option disabled selected></option>";
                    $status = true;
                    $msg = null;
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".$row['kel_id']."'>".$row['kel_name']."</option>";
                    }
                }else{
                    $status = false;
                    $msg = 'Tidak ada kelurahan';
                }
               
                
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function country(){
       
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $output .= "<option disabled selected></option>";
                $status = true;
                
                $msg = null;
                $data = $this->model_app->view_order('negara','neg_name','ASC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        // if($row['neg_name'] == 'Indonesia'){
                        //     $output .= "<option value='".$row['neg_name']."' selected>".$row['neg_name']."</option>";
                        // }else{
                        //     $output .= "<option value='".$row['neg_name']."'>".$row['neg_name']."</option>";
                        // }
                        $output .= "<option value='".$row['neg_name']."'>".$row['neg_name']."</option>";
                    }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
        
    }
    function job(){
       
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            if($status == 1){
                $output .= "<option disabled selected></option>";
                $status = true;
                
                $msg = null;
                $data = $this->model_app->view_order('jenis_pekerjaan','jp_name','ASC');
                if($data->num_rows() > 0){
                    foreach($data->result_array() as $row){
                        $output .= "<option value='".encode($row['jp_id'])."'>".$row['jp_name']."</option>";
                    }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$output));
        }else{
            $this->load->view('501');
        }
        
    }
    function data(){
        if($this->input->method() == 'post'){
            $status = __ceksesskonten('internal/users');
            $output = null;
            $user = $this->model_app->view_where('users',array('users_id'=>decode($this->session->userdata['internal']['id'])))->row_array();
            $sts = $this->input->post('status');
            $start = $this->input->post('start');
            $end = $this->input->post('end');
            if($status == 1){
                $output .= '<table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                       
                        <th>No Pengajuan</th>
                        <th>Yang Mengajukan</th>
                        <th>Pelayanan</th>
                        
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>                   
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>';
                $data =$this->model_app->dataPelayanan($sts,$start,$end);
                if($data->num_rows() > 0){
                    // $e = __ceksesskonten('internal/administrasi/edit');
                    $h = __ceksesskonten('internal/administrasi/delete');
                    
                    $d = __ceksesskonten('internal/administrasi/detail');

                    $no =1;
                    foreach($data->result_array() as $row){
                        if($row['pm_status'] == 'proses'){
                            if($row['pm_approve_kaling'] == NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                $con = 'Proses <br><small>Dalam proses kaling</small>';
                            }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                $con = 'Proses <br><small>Dalam proses pegawai</small>';
                            }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                                $con = 'Proses <br><small>Dalam proses lurah</small>';
                            }
                        }else if($row['pm_status'] == 'done'){
                            $con = 'Pengajuan selesai';
                        }else if($row['pm_status'] == 'cancel'){
                            if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                $con = 'Cancel <br><small>Dibatlakn kaling</small>';
                            }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                                $con = 'Cancel <br><small>Dibatalkan pegawai</small>';
                            }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] != NULL){
                                $con = 'Cancel <br><small>Dibatalkan lurah</small>';
                            }
                        }else{
                            $con = ucfirst($row['pm_status']);
                        }
                        $sub = $this->model_app->join_where('pelayanan','sub_pelayanan','pelayanan_id','subpel_pelayanan_id',array('pelayanan_id'=>$row['pm_pelayanan_id'],'subpel_id'=>$row['pm_subpel_id']))->row_array();
                        $output .= '<tr>
                         
                            <td>#'.$row['pm_no'].'</td>
                            <td>'.$row['temp_fullname'].'</td>
                            <td>'.$sub['pelayanan_name'].' <br> <small>'.$sub['subpel_name'].'</small></td>
                        
                            <td>'.date('d/m/Y',strtotime($row['pm_date'])).'</td>
                            <td>'.$con.'</td>
                            <td>';
                          
                            // if($e > 0 AND $row['pm_status'] =='proses'){
                            //     $output .= '<a href="'.base_url('internal/administrasi/edit?id='.encode($row['pm_id'])).'" class="btn btn-primary btn-sm btn-icon"><i class="feather icon-edit"></i></a>';
                            // }
                            if($d > 0 ){
                                $output .= '<a href="'.base_url('internal/administrasi/detail?id='.encode($row['pm_id'])).'" class="btn btn-info btn-sm btn-icon"><i class="fa fa-eye"></i></a>';
                            }
                            if($h > 0 AND $row['pm_status'] =='proses'){
                                if($row['pm_approve_kaling'] == NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                     $output .= '<button data-id="'.encode($row['pm_id']).'" class="btn btn-danger btn-sm btn-icon"><i class="fa fa-trash"></i></button>';
                                    
                                }
                            }
                            
                            $output .= '</td>
                        </tr>';
                    }
                }
               
                $output .= "</tbody>
                            </table>";
                $status = true;
                $msg = null;

            }else{
                $status = false;
                $msg ='Unauthorize';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'output'=>$output));

        }else{
            $this->load->view('501');
        }
    }
}