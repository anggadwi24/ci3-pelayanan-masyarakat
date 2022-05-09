<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }

    public function index() {
       
        $data['title'] = 'Internal Kelurahan Renon';
        
           
        $data['page'] = 'Dashboard';
        $data['header'] = 'Dashboard';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Dashboard</a></li>';	

        
        $data['js'] = base_url('template/admin/ajax/basic.js');
        $this->template->load('template','mod_dashboard/view_dashboard',$data);


    }
    function dataMenu(){
        if($this->input->method() == 'post'){
            $id = decode($this->session->userdata['internal']['id']);
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            
            $output = null;
            if($cek->num_rows() > 0){
                $output = ' <li data-username="'.str_replace(' ','_',strtolower('dashboard')).'" class="nav-item"><a href="'.base_url('internal/dashboard').'" class="nav-link" ><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>';

                $row = $cek->row_array();
                $umod = $this->db->query("SELECT * FROM users_modul a JOIN modul b on a.umod_modul_id = b.modul_id WHERE a.umod_users_id = '".$id."'  GROUP BY a.umod_modul_id  ORDER BY b.modul_urutan ASC");
		        if($umod->num_rows() > 0 ){
                    foreach($umod->result_array() as $menu){
                        $sbmenu = $this->db->query("SELECT * FROM users_modul a JOIN submodul b on a.umod_submodul_id = b.submodul_id WHERE a.umod_users_id = '".$id."' AND a.umod_modul_id = ".$menu['modul_id']." AND b.submodul_publish ='y'  ORDER BY b.submodul_id ASC");

                            if($sbmenu->num_rows() > 0){
                                $output.='    
                                        <li data-username="'.str_replace(' ','_',strtolower($menu['modul_name'])).'" class="nav-item pcoded-hasmenu  pcoded-trigger">
                                                <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="'.$menu['menu_icon'].'"></i></span><span class="pcoded-mtext">'.ucfirst($menu['menu_name']).'</span></a>
                                                <ul class="pcoded-submenu">
                           
                                        ';
                                         foreach($sbmenu->result_array() as $sm){
                                        $output.='    <li class=""><a href="'. base_url().$sm['submodul_link'].'">'. $sm['submodul_name'].'</a></li> ';
                                         }
                                            $output.='
                                            </ul>
                                        </li>
                                ';
                                
                             }else{
                                    $output .=
                                    ' <li data-username="'.str_replace(' ','_',strtolower($menu['menu_name'])).'" class="nav-item"><a href="'.base_url().$menu['modul_url'].'" class="nav-link" ><span class="pcoded-micon"><i class="'.$menu['menu_icon'].'"></i></span><span class="pcoded-mtext">'.ucfirst($menu['menu_name']).'</span></a></li>';
                                    
                                    
                            }
                        }
                }
            }else{
                $status = false;
                $msg = 'Unauthorized Access';
            }
        }else{
            $this->load->view('501');
        }
    }


    

    

}
