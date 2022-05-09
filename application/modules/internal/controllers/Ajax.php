<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>site_url()));
        __session();

    }

    public function index() {
       $this->load->view('501');


    }
    function ddd(){
        $this->model_app->view_where('1view');

    }
    function tie(){
        echo date('Y-m-d H:i:s');
    }
    function telegram(){
        pushTelegram('haaa');
    }
    function dataNotif(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            
            $output = null;
            if($cek->num_rows() > 0){
                $status = true;
                $msg = null;
                $data = $this->model_app->view_where_ordering('notifications',array('notif_users_id'=>$id,'notif_visible'=>'y'),'notif_id','DESC');
                if($data->num_rows() > 0){
                    foreach ($data->result_array() as $row) {
                        if($row['notif_read'] == 'y'){
                            $class = '';
                        }else{
                            $class = 'active';
                        }
                        if($row['notif_type'] == 'y'){
                            
                            $icon = '<button type="button" class="btn btn-icon btn-rounded btn-success"><i class="feather icon-check-circle"></i></button>';
                            
                        }else{
                            $icon = '<button type="button" class="btn btn-icon btn-rounded btn-danger"><i class="feather icon-x-circle"></i></button>';
                        }
                        $output .= '<li class="notification notif '.$class.'" data-href="'.$row['notif_link'].'" data-notif="'.encode($row['notif_id']).'">
                                        <div class="media">
                                            <span class="i">'.$icon.'</span>
                                            <div class="media-body">
                                                <p><strong>'.$row['notif_title'].'</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>'.lastTime($row['notif_created_on']).'</span></p>
                                                <p>'.$row['notif_desc'].'</p>
                                            </div>
                                        </div>
                                    </li>';
                    }
                }else{
                    $output ='<li class="n-title">
                                    <p class="m-b-0"><i>Tidak ada notifikasi</i></p>
                                </li>';
                }
            }else{
                $status = false;
                $msg = 'You are not authorized to access this page';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'html'=>$output));
        }else{
            $this->load->view('501');
        }
    }
    function readNotif(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);

            $data = array('notif_read'=>'y');
            $where = array('notif_users_id'=>$id,'notif_read'=>'n','notif_visible'=>'y');
            $this->model_app->update('notifications',$data,$where);
            $status = true;
            $msg = null;
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function clearNotif(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);

            $data = array('notif_visible'=>'n');
            $where = array('notif_users_id'=>$id);
            $this->model_app->update('notifications',$data,$where);
            $status = true;
            $msg = null;
            echo json_encode(array('status'=>$status,'msg'=>$msg));

        }else{
            $this->load->view('501');
        }
    }
    function updateNotif(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('notifications',array('notif_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->update('notifications',array('notif_read'=>'y'),array('notif_id'=>$id));
                $status = true;
                $msg = null;
            }else{
                $status = false;
                $msg = 'Notifikasi telah expired';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function cek(){
        echo $this->uri->segment('1').'/'.$this->uri->segment('2');
    }
    function dataMenu(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            
            $output = null;
            if($cek->num_rows() > 0){
                $status = true;
                $msg= null;
                $output = ' <li data-username="'.str_replace(' ','_',strtolower('dashboard')).'" class="nav-item"><a href="'.base_url('internal/dashboard').'" class="nav-link" ><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>';
                $modUrl = $this->uri->segment('1').'/'.$this->uri->segment('2');
                $subUrl = $this->uri->segment('1').'/'.$this->uri->segment('2').'/'.$this->uri->segment('3');
                $row = $cek->row_array();
                $umod = $this->db->query("SELECT * FROM users_modul a JOIN modul b on a.umod_modul_id = b.modul_id WHERE a.umod_users_id = '".$id."'  GROUP BY a.umod_modul_id  ORDER BY b.modul_order ASC");
		        if($umod->num_rows() > 0 ){
                    foreach($umod->result_array() as $menu){
                        $sbmenu = $this->db->query("SELECT * FROM users_modul a JOIN submodul b on a.umod_submodul_id = b.submodul_id WHERE a.umod_users_id = '".$id."' AND a.umod_modul_id = ".$menu['modul_id']." AND b.submodul_publish ='y'  ORDER BY b.submodul_id ASC");

                            if($sbmenu->num_rows() > 0){
                                $output.='    
                                        <li data-username="'.str_replace(' ','_',strtolower($menu['modul_name'])).'" class="nav-item pcoded-hasmenu  ">
                                                <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="'.$menu['modul_icon'].'"></i></span><span class="pcoded-mtext">'.ucfirst($menu['modul_name']).'</span></a>
                                                <ul class="pcoded-submenu">
                           
                                        ';
                                         foreach($sbmenu->result_array() as $sm){
                                        $output.='    <li class=""><a href="'. base_url().$sm['submodul_link'].'" class="">'. $sm['submodul_name'].'</a></li> ';
                                         }
                                            $output.='
                                            </ul>
                                        </li>
                                ';
                                
                             }else{
                                    if($menu['modul_url'] == $modUrl){
                                        $output .=
                                        ' <li data-username="'.str_replace(' ','_',strtolower($menu['modul_name'])).'" class="nav-item active"><a href="'.base_url().$menu['modul_url'].'" class="nav-link" ><span class="pcoded-micon"><i class="'.$menu['modul_icon'].'"></i></span><span class="pcoded-mtext">'.ucfirst($menu['modul_name']).'</span></a></li>';
                                       
                                    }else{
                                        $output .=
                                        ' <li data-username="'.str_replace(' ','_',strtolower($menu['modul_name'])).'" class="nav-item "><a href="'.base_url().$menu['modul_url'].'" class="nav-link" ><span class="pcoded-micon"><i class="'.$menu['modul_icon'].'"></i></span><span class="pcoded-mtext">'.ucfirst($menu['modul_name']).'</span></a></li>';
                                       
                                    }
                                    
                                    
                            }
                        }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'output'=>$output));
        }else{
            $this->load->view('501');
        }
    }


    

    

}
