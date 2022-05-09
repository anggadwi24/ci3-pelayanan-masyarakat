<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MX_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();

    }
    function menu(){
        __ceksess('internal/website/menu');

        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Menu Website';
        $data['header'] = 'Menu Website';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a >Website</a></li>';

        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="'.base_url('internal/website/menu').'">Menu Website</a></li>';
        $data['js'] = base_url('template/admin/ajax/website/ajax-menu-web.js');
        $data['menu'] = $this->model_app->view_order('menu','menu_name','ASC');
        $this->template->load('template_drag','mod_website/view_menu_website',$data);
    }
    function dataParent(){
        if($this->input->method() == 'post'){
            $output = '<option value="">Parent</option>';
           $data = $this->model_app->view_where('menu_website',array('mw_parent'=>NULL),'mw_urutan','DESC');
           if($data->num_rows() > 0){
                foreach($data->result_array() as $row){
                    $output .= "<option value='".encode($row['mw_id'])."'>".$row['mw_name']."</option>";
                }
           }
           echo json_encode($output);
        }else{
            $this->load->view('501');
        }
    }
    function menuEdit(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('menu_website',array('mw_id'=>$id));
            $data = null;
            
            if($cek->num_rows() > 0){
                $status = true;
                $msg = null;
                $row=$cek->row_array();
                if($row['mw_parent'] == NULL){
                    $parent = 'Parent';
                }else{  
                    $prt = $this->model_app->view_where('menu_website',array('mw_id'=>$row['mw_parent']))->row_array();
                    $parent = $prt['mw_name'];
                }
                
                $data = array('id'=>encode($row['mw_id']),'link'=>$row['mw_link'],'menu'=>$row['mw_name'],'parent'=>$parent);

            }else{
                $status = false;
                $msg = 'Menu tidak ditemukan';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg,'data'=>$data));
        }else{
            $this->load->view('501');
        }
    }
    function store(){
        if($this->input->method() == 'post'){
            $pt = $this->input->post('parent');
            if($pt == ''){
                $parent = NULL;
            }else{
                $parent = decode($pt);
            }
            $menu = $this->input->post('menu');
            $link = $this->input->post('link');
            $last = $this->db->query("SELECT * FROM menu_website WHERE mw_parent IS NULL ORDER BY mw_urutan DESC LIMIT 1")->row_array();
            $data= array(
                'mw_parent'=>$parent,
                'mw_name'=>$menu,
                'mw_link'=>$link,
                'mw_urutan'=>$last['mw_urutan']+1,
            );
            $this->model_app->insert('menu_website',$data);
            $status = true;
            $msg = 'Menu berhasil ditambah';
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function updateMenu(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('menu_website',array('mw_id'=>$id));
            if($cek->num_rows() > 0){
                $pt = $this->input->post('parent');
                if($pt == ''){
                    $parent = NULL;
                }else{
                    $parent = decode($pt);
                }
                $menu = $this->input->post('menu');
                $link = $this->input->post('link');
               
                $data= array(
                    'mw_parent'=>$parent,
                    'mw_name'=>$menu,
                    'mw_link'=>$link,
                  
                );
                $this->model_app->update('menu_website',$data,array('mw_id'=>$id));
                $status = true;
                $msg = 'Menu berhasil diubah';
            }else{
                $status = false;
                $msg = 'Menu tidak ditemukan';
            }
           
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function data(){
        if($this->input->method() == 'post'){
            $output = null;
            $delete = __ceksesskonten('internal/website/menuDelete');
            $edit = __ceksesskonten('internal/website/menuEdit');

            $data = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>NULL),'mw_urutan','ASC');
            if($data->num_rows() > 0){
                
                $output .= '<ol class="dd-list ol-name" >';
                foreach($data->result_array() as $row){
                    if($edit){
                        $class='class="li-name"';
                    }else{
                        $class = '';
                    }
                    if($delete){
                        $hapus = '<span class=" text-danger p-1 float-right mb-1 delete " data-id="'.encode($row['mw_id']).'" data-dismiss="alert" aria-label="close"><i class="feather icon-trash"></i></span>';
                    }else{
                        $hapus ='';
                    }
                    $child = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>$row['mw_id']),'mw_urutan','ASC');
                    $output .='<li class="dd-item" data-id="'.$row['mw_id'].'">
                                    <div class="dd-handle"><span '.$class.' data-id="'.encode($row['mw_id']).'">'.$row['mw_name'].'</span>'.$hapus.'</div>
                              ';
                    if($child->num_rows() > 0){
                        foreach($child->result_array() as $chd){
                            if($edit){
                                $classes='class="li-name"';
                            }else{
                                $classes = '';
                            }
                            if($delete){
                                $hapuss = '<span class=" text-danger p-1 float-right mb-1 delete " data-id="'.encode($chd['mw_id']).'" data-dismiss="alert" aria-label="close"><i class="feather icon-trash"></i></span>';
                            }else{
                                $hapuss ='';
                            }
                            $output .='<ol class="dd-list ol-name" >
                                            <li class="dd-item" data-id="'.$chd['mw_id'].'"  >
                                                <div class="dd-handle "><span '.$classes.' data-id="'.encode($chd['mw_id']).'">'.$chd['mw_name'].'</span>'.$hapuss.'</div>
                                                
                                            </li>
                                        </ol>';
                        }
                    }
                    $output .='</li>';
                }
                $output .='</ol>';
            }
            echo json_encode($output);
        }else{
            $this->load->view('501');
        }
    }
    
    function dataMenu(){
        if($this->input->method() == 'post'){
            $output = null;
            $data = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>NULL),'mw_urutan','ASC');
            if($data->num_rows() > 0){
                $output .= '<ol class="dd-list ol-name" >';
                foreach($data->result_array() as $row){
                    $child = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>$row['mw_id']),'mw_urutan','ASC');
                    $output .='<li class="dd-item" data-id="'.$row['mw_id'].'">
                                    <div class="dd-handle"><span class="li-name">'.$row['mw_name'].'</span></div>
                              ';
                    if($child->num_rows() > 0){
                        foreach($child->result_array() as $chd){
                            $output .='<ol class="dd-list ol-name" >
                                            <li class="dd-item" data-id="'.$chd['mw_id'].'"  >
                                                <div class="dd-handle"><span class="li-name">'.$chd['mw_name'].'</span> </div>
                                                
                                            </li>
                                        </ol>';
                        }
                    }
                    $output .='</li>';
                }
                $output .='</ol>';
            }
            echo json_encode($output);
        }else{
            $this->load->view('501');
        }
    }
    function updateOrdering(){
        if($this->input->method() == 'post'){
            $output = null;
            $data = $this->input->post('data');
            $count = count($data);
            if($count > 0){
                for($i=0;$i<$count;$i++){
                    $output .= $data[$i]['id'].'<br>';
                    $id = $data[$i]['id'];
                    $urutan = $i;
                    $this->model_app->update('menu_website',array('mw_urutan'=>$i,'mw_parent'=>NULL),array('mw_id'=>$id));
                    // $this->db->where('mw_id',$data[$i]['id']);
                    // $this->db->update('menu_website',array('mw_urutan'=>$i));
                    $countChild = count($data[$i]['children']);
                    if($countChild > 0 ){
                        for($j=0;$j<$countChild;$j++){
                            $output .= $data[$i]['children'][$j]['id'].'<br>';
                            $child = $data[$i]['children'][$j]['id'];
                            $parent = $data[$i]['id'];
                            $urutan = $j;
                           

                            $where = array('mw_id'=>$data[$i]['children'][$j]['id']);
                            $dataC = array('mw_parent'=>$parent,'mw_urutan'=>$urutan);
                            $this->model_app->update('menu_website',$dataC,$where);
                        }
                    }
                }
            }
            
        }
    }
    function dataSuggestion(){
        if($this->input->method() == 'post'){
            $output = null;
            $data = $this->model_app->view_order('menu','menu_name','ASC');
            if($data->num_rows() > 0){
                $no=1;
                $output .= '<ol class="dd-list">';
                foreach($data->result_array() as $row){
                    
                        $mw = $this->model_app->view_where('menu_website',array('mw_link'=>$row['menu_link']));
                        if($mw->num_rows() == 0){
                            $output .= ' <li class="dd-item" data-id="'.encode($row['menu_id']).'" >
                                        <div class="dd-handle">'.$row['menu_name'].'</div>
                                    </li>';
                            $no++;
                        
                    }
                    
                  
                }
                $output .='</ol>';
            }
            echo json_encode($output);
        }else{
            $this->load->view('501');
        }
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
        __ceksess('internal/website/menuDelete');
        $id = decode($this->input->post('id'));
        if($this->input->method() == 'post'){
            $cek= $this->model_app->view_where('menu_website',array('mw_id'=>$id));
            if($cek->num_rows() > 0){
                $this->model_app->delete('menu_website',array('mw_id'=>$id));
                // $this->model_app->delete('jabatan',array('jabatan_id'=>$id));
                $status = true;
                $msg = 'Menu berhasil dihapus';
                
            }else{
               $status = false;
               $msg = 'Menu tidak ditemukan!';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
        
    }

}