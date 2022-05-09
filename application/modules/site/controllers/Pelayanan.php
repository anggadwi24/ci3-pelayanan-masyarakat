<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
  
    }
    function index(){
        if(!empty($this->session->userdata('pm_id'))){
            $pm = decode($this->session->userdata('pm_id'));
            $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$pm,'pm_status'=>'undone'));
            if($cek->num_rows() > 0){

                $this->session->set_flashdata('message','Lengkapi pelayanan terlebih dahulu');
                redirect('pelayanan/complete');
            }else{
                $this->session->unset_userdata('pm_id');
                redirect('pelayaan/pengajuan');
            }
        }else{
            $this->output->set_header('Key: '.encode(keys()));
            $this->output->set_header('HTTP/1.0 200 OK');
            $this->output->set_header('HTTP/1.1 200 OK');
            $data['title'] = 'Pengajuan Pelayanan - Kelurahan Renon';
            $data['widget'] = $this->recaptcha->getWidget();
            $data['script'] = $this->recaptcha->getScriptTag();
            $data['js'] = base_url('template/public/js/ajax/pelayanan/ajax-pengajuan.js');
            $data['breadcumb'] = '<li class="breadcrumb-item"><a href="'.base_url('').'">Home</a></li>';
            $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="#">Pelayanan</a></li>';
            $data['breadcumb'] .= '<li class="breadcrumb-item active" aria-current="page">Pengajuan</li>';

        
        
            $this->template->load('template','mod_pelayanan/view_pengajuan',$data);
        }
           
    }
    function tracking(){
        $this->output->set_header('Key: '.encode(keys()));
        $this->output->set_header('HTTP/1.0 200 OK');
        $this->output->set_header('HTTP/1.1 200 OK');
        $data['title'] = 'Pelacakan Pelayanan - Kelurahan Renon';
       
        $data['js'] = base_url('template/public/js/ajax/pelayanan/ajax-tracking.js');
        $data['breadcumb'] = '<li class="breadcrumb-item"><a href="'.base_url('').'">Home</a></li>';
        $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="#">Pelayanan</a></li>';
        $data['breadcumb'] .= '<li class="breadcrumb-item active" aria-current="page">Pelacakan</li>';

    
    
        $this->template->load('template','mod_pelayanan/view_tracking',$data);
    }
    
    function complete(){
        $pm = decode($this->session->userdata('pm_id'));
        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$pm));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            if($row['pm_status'] == 'undone'){
                $data['row'] = $cek->row_array();
                $this->output->set_header('Key: '.encode(keys()));
                $this->output->set_header('HTTP/1.0 200 OK');
                $this->output->set_header('HTTP/1.1 200 OK');
                $data['title'] = 'Pelengkapanan Pelayanan - Kelurahan Renon';
                $data['widget'] = $this->recaptcha->getWidget();
                $data['script'] = $this->recaptcha->getScriptTag();
                $data['js'] = base_url('template/public/js/ajax/pelayanan/ajax-completed.js');
                $data['sub'] = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']))->row_array();
                $data['pel'] = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$row['pm_pelayanan_id']))->row_array();
                $data['banjar'] = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                $data['temp'] = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                $data['breadcumb'] = '<li class="breadcrumb-item"><a href="'.base_url('').'">Home</a></li>';
                $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="#">Pelayanan</a></li>';
                $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('pelayanan/pengajuan').'">Pengajuan</a></li>';

                $data['breadcumb'] .= '<li class="breadcrumb-item active" aria-current="page">Pelengkapan</li>';
    
            
            
                $this->template->load('template','mod_pelayanan/view_complete',$data);
            }else{
                $this->session->set_flashdata('message','Pelayanan sudah dilengkapi');
                redirect('pelayanan');
            }
        }else{
            $this->session->set_flashdata('message','Pelayanan tidak ditemukan');
            redirect('pelayanan');
        }
    }
    function doTrack(){
        if($this->input->method() == 'post'){
            $status =  __checkConnect(base_url('pelayanan/tracking'),decode($this->input->post('api')));
            $output = null;
            if($status == 1){
                $email = $this->input->post('email');
                $no = $this->input->post('no');
                $recaptha = $this->input->post('g-recaptcha-response');
                if(!empty($recaptha)){
                    $response = $this->recaptcha->verifyResponse($recaptha);
                    if(isset($response['success']) and $response['success'] === true){
                        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_email'=>$email,'pm_no'=>$no));
                        if($cek->num_rows() > 0 ){
                            $row = $cek->row_array();
                            if($row['pm_status'] == 'undone'){
                                $status = false;
                                $msg = 'Pelayanan belum dilengkapi';
                            }else{
                                if($row['pm_status'] == 'proses'){
                                    if($row['pm_approve_kaling'] == NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                        $con = 'Dalam proses verifikasi kaling';
                                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                        $con = 'Dalam proses verifikasi pegawai';
                                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                                        $con = 'Dalam proses verifikasi lurah';
                                    }
                                }else if($row['pm_status'] == 'done'){
                                    $con = 'Pengajuan selesai';
                                }else if($row['pm_status'] == 'cancel'){
                                    if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                                        $con = 'Ditolak oleh kaling';
                                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] == NULL){
                                        $con = 'Ditolak oleh pegawai';
                                    }else if($row['pm_approve_kaling'] != NULL AND $row['pm_approve_pegawai'] != NULL AND $row['pm_approve_lurah'] != NULL){
                                        $con = 'Ditolak oleh lurah';
                                    }
                                }else{
                                    $con = ucfirst($row['pm_status']);
                                }
                                $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']))->row_array();
                                $pel = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$row['pm_pelayanan_id']))->row_array();
                                $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                                $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                                $status = true;
                                $msg = null;
                                $output .= '<div class="card">';
                                $output .= '<div class="card-body">';
                                $output .= '<div class="row g-4">';
                                $output .= '<div class="col-12 my-3"><h5 class="my-3 card-title">Pelayanan No. #'.$row['pm_no'].'</h5></div>';
                                $output .= '<div class="col-12 "><h6>Nama Pemohon : '.$temp['temp_fullname'].'</h6></div>';
                                $output .= '<div class="col-12 "><h6>Email Pemohon : '.$row['pm_email'].'</h6></div>';
                                $output .= '<div class="col-12 "><h6>Pelayanan : '.$pel['pelayanan_name'].' - '.$sub['subpel_name'].'</h6></div>';
                                $output .= '<div class="col-12 "><h6>Status : '.$con.'</h6></div>';




                                $output .= '</div>';
                                $output .= '</div>';
                                $output .= '</div>';
                            }
                        }else{
                            $status = false;
                            $msg = 'Pelayanan tidak ditemukan';
                        }
                    }else{
                        $status = false;
                        $msg = 'Captcha tidak valid';
                    }
                }else{
                    $status = false;
                    $msg = 'Harap verifikasi captcha';
                }
                
            }else{
                $status = false;
                $msg = 'Unauthorize accesss';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'output'=>$output));
        }else{
            $this->output->set_status_header(500);

            $this->load->view('501');
        }
    }
    function done(){
        $pm = decode($this->input->get('pm'));
        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$pm,'pm_status'=>'proses'));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            if($row['pm_approve_kaling'] == NULL AND $row['pm_approve_pegawai'] == NULL AND $row['pm_approve_lurah'] == NULL){
                $data['row'] = $cek->row_array();
                $this->output->set_header('Key: '.encode(keys()));
                $this->output->set_header('HTTP/1.0 200 OK');
                $this->output->set_header('HTTP/1.1 200 OK');
                $data['title'] = $row['pm_no'].' - Kelurahan Renon';
                $data['sub'] = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']))->row_array();
                $data['pel'] = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$row['pm_pelayanan_id']))->row_array();
                $data['banjar'] = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                $data['temp'] = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                $data['js'] = '';
              
                $data['breadcumb'] = '<li class="breadcrumb-item"><a href="'.base_url('').'">Home</a></li>';
                $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="#">Pelayanan</a></li>';
                $data['breadcumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('pelayanan/pengajuan').'">Pengajuan</a></li>';

                $data['breadcumb'] .= '<li class="breadcrumb-item " ><a>Pelengkapan</a></li>';
                $data['breadcumb'] .= '<li class="breadcrumb-item active" aria-current="page">Selesai</li>';

    
            
            
                $this->template->load('template','mod_pelayanan/view_done',$data);
            }else{
                $this->session->set_flashdata('message','Pelayanan tidak dalam proses');
                redirect('pelayanan');
            }
        }else{
            $this->session->set_flashdata('message','Pelayanan tidak ditemukan');
            redirect('pelayanan');
        }
    }
    function update(){
        if($this->input->method() == 'post'){
            $status =  __checkConnect(base_url('pelayanan/complete'),decode($this->input->post('api')));
            $redirect = null;
            if($status == 1){
                $id = decode($this->session->userdata('pm_id'));
                $recaptha = $this->input->post('g-recaptcha-response');
                if(!empty($recaptha)){
                    $response = $this->recaptcha->verifyResponse($recaptha);
                    if(isset($response['success']) and $response['success'] === true){
                        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
                        if($cek->num_rows() > 0){
                            $row =$cek->row_array();
                            if($row['pm_status'] == 'undone'){
                                $sub = $this->model_app->view_where('sub_pelayanan',array('subpel_id'=>$row['pm_subpel_id']));
                                    if($sub->num_rows() > 0){
                                        $rows = $sub->row_array();
                                        $link = 'add_'.str_replace('"','',$rows['subpel_link']);
                                        if (method_exists($this,$link)) {
                                            // $status =true;
                                            $msg = null;
                                        
                                            $content = $this->$link($this->input->post(),$id);
                                            if($content == true){
                                                $temp = $this->model_app->view_where('masyarakat_temp',array('temp_id'=>$row['pm_temp_id']))->row_array();
                                                $this->model_app->update('pelayanan_masyarakat',array('pm_status'=>'proses'),array('pm_id'=>$id));
                                                $status = true;
                                                $msg = 'Pengajuan berhasil diselesaikan';
                                                $redirect = base_url('pelayanan/done?pelayanan='.encode($id));
                                                $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
                                                $kaling = $this->model_app->view_where('users',array('users_id'=>$banjar['banjar_kaling']))->row_array();
                                                $title = 'Pelayanan No. #'.$row['pm_no'];
                                                $desc = 'Pelayanan dengan nomor #'.$row['pm_no'].' telah diajukan, silahkan menyetujui atau menolaknya';
                                                $link = base_url().'internal/administrasi/detail?id='.encode($id);
                                                $html = "Pelayaanan #".$row['pm_no']." telah diajukan<br><br>Nama : ".$temp['temp_fullname']." <br>NIK : ".$temp['temp_nik']." <br>Banjar : ".$banjar['banjar_name']."<br><br>silahkan untuk kepala lingkungan terkait menyetujui atau menolaknya <br><br> Detail : $link";
                                                pushNotification('kaling',$title,$desc,$link,'n','internal/administrasi/approve',$banjar['banjar_kaling']);
                                                
                                                pushTelegram($html);
                                                $this->session->unset_userdata('pm_id');
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
                        $msg = 'Wrong Recaptha';
                    }
                }else{
                    $status = false;
                    $msg = 'Recaptcha belum diinput';
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
            $redirect = null;
            if($status == 1 ){
                $this->form_validation->set_rules('pelayanan','Pelayanan','required');
                $this->form_validation->set_rules('sub_pelayanan','Sub Pelayanan','required');
                $this->form_validation->set_rules('banjar','Banjar','required');
                $this->form_validation->set_rules('email','Email ','required');
                $this->form_validation->set_rules('nik','NIK','required');
                $this->form_validation->set_rules('fullname','Nama Lengkap','required');
                $this->form_validation->set_rules('religion','Agama','required');


                $config['upload_path']          = './upload/identity/';
                $config['allowed_types']        = 'gif|jpg|png';
            
                $config['encrypt_name'] = TRUE;
            
                $config['max_size']             = 50000;
                $this->load->library('upload', $config);
                $recaptha = $this->input->post('g-recaptcha-response');

                if($this->form_validation->run() === FALSE){
                    $status = false;
                    $msg = replace(array('<p>','</p>'),validation_errors());
                }elseif(!$this->upload->do_upload('file')){
                    $status = false;
                    $msg =  replace(array('<p>','</p>'),$this->upload->display_errors());
                }else{
                    $pm_no = generatePelayananNo();
                    $upload_data = $this->upload->data();
                    $identity = $upload_data['file_name'];
                    $pelayanan = decode($this->input->post('pelayanan'));
                    $sub_pelayanan = decode($this->input->post('sub_pelayanan'));
                    $banjar = decode($this->input->post('banjar'));
                
                    $cekPelayanan = $this->model_app->view_where('pelayanan',array('pelayanan_id'=>$pelayanan));
                    if(!empty($recaptha)){
                        $response = $this->recaptcha->verifyResponse($recaptha);
                        if(isset($response['success']) and $response['success'] === true){
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
                                                            'pm_created_by'=>NULL,
                                                        );
                                            $pm_id = $this->model_app->insert_id('pelayanan_masyarakat',$dataPM);
                                            $status = true;
                                            $msg = 'Lanjutkan pelengkapan data pengajuan';
                                            $this->session->set_userdata('pm_id',encode($pm_id));
                                            $redirect = base_url('pelayanan/complete');
                                            
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
                        }else{
                            $status = false;
                            
                            $msg = 'Wrong recaptcha';
                        }
                    }else{
                        $status = false;
                        
                        $msg = 'Masukan recaptcha';
                    }
                   
                }
            }else{
                $this->output->set_status_header(401);

                $status = false;
                $msg = 'Unathorize Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'redirect'=>$redirect));
        }else{
            $this->output->set_status_header(501);
            $this->load->view('501');
        }
    
    }
    private function add_surat_keterangan_usaha($post,$id){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>$id,'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_alamat_usaha'=>$post['alamat_usaha']);
            $this->model_app->insert('surat_keterangan_usaha',$data);
            return true;
        }else{
            return false;
        }
    }
    private function add_surat_keterangan_domisili_usaha($post,$id){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>$id,'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_alamat_usaha'=>$post['alamat_usaha']);
            $sku_id = $this->model_app->insert_id('surat_keterangan_usaha',$data);
            $data1 = array('skdu_sku_id'=>$sku_id,'skdu_keperluan'=>$post['keperluan'],'skdu_pm_id'=>$id);
            $this->model_app->insert('surat_keterangan_domisili_usaha',$data1);
            return true;
        }else{
            return false;
        }
    }
    private function add_surat_keterangan_usaha_tidak_berjalan($post,$id){
        if($this->input->method() == 'post'){
            $data = array('sku_nama_usaha'=>$post['nama_usaha'],'sku_pm_id'=>$id,'sku_jenis_usaha'=>$post['jenis_usaha'],'sku_tanggal_berdiri'=>date('Y-m-d',strtotime($post['tanggal_berdiri'])),'sku_keperluan'=>$this->input->post('keperluan'),'sku_status'=>'n','sku_alamat_usaha'=>$post['alamat_usaha']);
            $sku_id = $this->model_app->insert_id('surat_keterangan_usaha',$data);
            $data1 = array('skutb_sku_id'=>$sku_id,'skutb_tanggal_berhenti'=>date('Y-m-d',strtotime($post['tanggal_berhenti'])),'skutb_pm_id'=>$id);
            $this->model_app->insert('surat_keterangan_usaha_tidak_berjalan',$data1);
            return true;
        }else{
            return false;
        }
    }
    
}