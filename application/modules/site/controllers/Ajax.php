<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MX_Controller {

  

    function __construct() {
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('user_helper');
        if($this->input->method() != 'post'){
            $this->output->set_status_header(500);
            $this->load->view('501');
        }
  
    }
    function index(){
           $this->output->set_status_header(500);
           $this->load->view('501');
    }

    function subPelayanan(){
        if($this->input->method() == 'post'){
            $status = __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
    function pelayanan(){
        if($this->input->method() == 'post'){
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
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
    function reCaptcha(){
        if($this->input->method() == 'post'){
            $status =  __checkConnect(base_url('pelayanan/pengajuan'),decode($this->input->post('api')));
            $status1 =  __checkConnect(base_url('pelayanan/complete'),decode($this->input->post('api')));
            $status2 =  __checkConnect(base_url('pelayanan/tracking'),decode($this->input->post('api')));

            $arr = null;
            if($status == 1 OR $status1 == 1 OR $status2 == 1){
                $status = true;
                $msg = null;
                $arr['widget'] = $this->recaptcha->getWidget();
                $arr['script'] = $this->recaptcha->getScriptTag();
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$arr));
        }else{
            $this->output->set_status_header(501);
            $this->load->view('501');

        }
    }
    function dataCompleted(){
        if($this->input->method() == 'post'){
            $status =  __checkConnect(base_url('pelayanan/complete'),decode($this->input->post('api')));
            $content = null;
            if($status == 1){
                $id = decode($this->session->userdata('pm_id'));
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
                                    $this->output->set_status_header(500);
                                    $status = false;
                                    $msg = 'Method Not Found';
                                    $content = null;
                                }
                                
                            }else{
                                $this->output->set_status_header(500);
                                $status = false;
                                $msg ='Pelayanan tidak ditemukan';
                            }
                    }else{
                        $this->output->set_status_header(500);
                        $status = false;
                        $msg = 'Pelayanan sudah dilengkapi';
                    }
                }else{
                    $this->output->set_status_header(500);
                    $status = false;
                    $msg = 'Pelayanan Masyarakat tidak ditemukan';
                }
                
                
            }else{
                $this->output->set_status_header(500);

                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'content'=>$content));
        }else{
            $this->output->set_status_header(501);
            $this->load->view('501');
        }
    }
    private function surat_keterangan_usaha_tidak_berjalan(){
        $output = '
                   
        <div class="col-8 form-group">
             <label class="form-label">Nama Usaha</label>
            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
        </div>
        <div class="col-4 form-group">
             <label class="form-label">Jenis Usaha</label>
            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
        </div>
        <div class="col-12 form-group">
             <label class="form-label">Alamat Usaha</label>
            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
        </div>
        <div class="col-6 form-group">
             <label class="form-label">Tanggal Berdiri</label>
            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
        </div>
        <div class="col-6 form-group">
             <label class="form-label">Tanggal Berhenti</label>
            <input type="date" name="tanggal_berhenti" id="tanggal_berhenti" class="form-control" required >
        </div>
        <div class="col-12 form-group">
             <label class="form-label">Keperluan</label>
            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
        </div>

     ';
    return $output;
    }
    private function surat_keterangan_usaha(){
        $output = '
                   
                        <div class="col-8 form-group">
                             <label class="form-label">Nama Usaha</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                             <label class="form-label">Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
                        </div>
                        <div class="col-8 form-group">
                             <label class="form-label">Alamat Usaha</label>
                            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                             <label class="form-label">Tanggal Berdiri</label>
                            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
                        </div>
                        <div class="col-12 form-group">
                             <label class="form-label">Keperluan</label>
                            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
                        </div>

                     ';
        return $output;
    }
    private function surat_keterangan_domisili_usaha(){
        $output = '
                   
                        <div class="col-8 form-group">
                             <label class="form-label">Nama Usaha</label>
                            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                             <label class="form-label">Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" required >
                        </div>
                        <div class="col-8 form-group">
                             <label class="form-label">Alamat Usaha</label>
                            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required >
                        </div>
                        <div class="col-4 form-group">
                             <label class="form-label">Tanggal Berdiri</label>
                            <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required >
                        </div>
                        <div class="col-12 form-group">
                             <label class="form-label">Keperluan</label>
                            <input type="text" name="keperluan" id="keperluan" class="form-control" required >
                        </div>

                     ';
        return $output;
    }
}
