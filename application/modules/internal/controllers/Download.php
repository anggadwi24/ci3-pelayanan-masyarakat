<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>site_url()));
        __session();

    }

    public function index() {
        $file = decode($this->input->get('file'));
        $ex = explode('_',$file);
        $id = $ex[0];
        $cek = $this->model_app->view_where('pelayanan_masyarakat',array('pm_id'=>$id));
        if($cek->num_rows() > 0){
            $row = $cek->row_array();
            // $file = $row['pm_document'];
            // $path = './upload/document/'.$file;
            // $data = file_get_contents($path); // Read the file's contents
            // $name = $file;
            // force_download($name, $data);
            if($row['pm_status'] == 'done'){
                if($row['pm_document'] != '' || $row['pm_document'] != null || file_exists('./upload/document/'.$row['pm_document'])){
                    $file = $row['pm_document'];
                    $path = './upload/document/'.$file;
                    $data = file_get_contents($path); // Read the file's contents
                    $name = $file;
                    force_download($name, $data);
                    
                }else{
                    $this->session->set_flashdata('message','Document tidak ada');
                     redirect('internal/administrasi'); 
                }
                   
            }else{
                $this->session->set_flashdata('message','Pelayanan belum selesai');
                redirect('internal/administrasi');
            }
        }else{
            $this->session->set_flashdata('message','Pelayanan tidak ditemukan');
            redirect('internal/administrasi');
        }

        


    }
}