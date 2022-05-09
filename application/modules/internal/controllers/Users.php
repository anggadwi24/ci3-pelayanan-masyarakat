<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

 

    function __construct() {
        parent::__construct();
        
        $this->load->model('model_app','',TRUE);
        $this->load->helper('base_helper');
        $this->session->set_userdata(array('redirect'=>current_url()));
        __session();
        
      

    }

    public function index() {
        __ceksess('internal/users');

        $this->session->set_userdata(array('redirect'=>current_url()));
        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Users';
        $data['header'] = 'Users';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/users').'">User</a></li>';
        // $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="#!">Table</a></li>';
        $data['js'] = base_url('template/admin/ajax/user/ajax-users.js');
        $this->template->load('template','mod_users/view_users',$data);


    }
    function add(){
        __ceksess('internal/users/add');

        $this->session->set_userdata(array('redirect'=>current_url()));
        $data['title'] = 'Internal Kelurahan Renon';
        $data['page'] = 'Users';
        $data['header'] = 'Add Users';
        $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/users').'">User</a></li>';
        $data['breadcrumb'] .= '<li class="breadcrumb-item"><a href="#!">Add</a></li>';
        $data['js'] = base_url('template/admin/ajax/user/ajax-users-add.js');
        $this->template->load('template','mod_users/view_users_add',$data);
    }
    function edit(){
        __ceksess('internal/users/edit');

        $id = decode($this->input->get('id'));
        $cek = $this->model_app->view_where('users',array('users_id'=>$id));
        if($cek->num_rows() > 0){
            $data['row'] = $cek->row_array();
            $data['title'] = 'Internal Kelurahan Renon';
            $data['page'] = 'Users';
            $data['header'] = 'Edit Users';
            $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/users').'">User</a></li>';
            $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Edit</a></li>';
            $data['js'] = base_url('template/admin/ajax/user/ajax-users-add.js');
            $this->template->load('template','mod_users/view_users_edit',$data);
        }else{
            $this->session->set_flashdata('message','User not found!');
            redirect('internal/users');
        }
       
    }
    function delete(){
        __ceksess('internal/users/delete');

        if($this->input->method() == 'post' && $this->input->post('id') != NULL){
            $id = decode($this->input->post('id'));

            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                if($row['users_level'] == 'admin'){
                    $this->model_app->delete('users',array('users_id'=>$id));
                }else if($row['users_level'] == 'kaling'){
                    $getBjr = $this->model_app->view_where('banjar',array('banjar_kaling'=>$row['users_id']));
                    if($getBjr->num_rows() > 0){
                        $this->model_app->update('banjar',array('banjar_kaling'=>NULL),array('banjar_kaling'=>$row['users_id']));
                        
                    }
                    $this->model_app->delete('users',array('users_id'=>$id));
                    
                }else if($row['users_level'] == 'lurah' || $row['users_level'] == 'pegawai'){
                    $getJabatan = $this->model_app->view_where('jabatan',array('jabatan_id'=>$row['users_jabatan']));
                    if($getJabatan->num_rows() > 0){
                        $rowJ = $getJabatan->row_array();
                        $this->model_app->update('jabatan',array('jabatan_used'=>$rowJ['jabatan_used']-1),array('jabatan_id'=>$row['users_jabatan']));
                        
                    }
                    $this->model_app->delete('users',array('users_id'=>$id));
                }
                $this->model_app->delete('users_modul',array('umod_users_id'=>$row['users_id']));
               $msg = 'User berhasil dihapus!';
               $status =true;
            }else{
                $msg = 'User not found!';
                $status = false;
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function updateImage(){
        if($this->input->method() == 'post'){
            $url = null;
            $msg = null;
            $cek = $this->model_app->view_where('users',array('users_id'=>decode($this->input->post('id'))));
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
                    $this->model_app->update('users',array('users_photo'=>$foto),array('users_id'=>decode($this->input->post('id'))));
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
    function updatePassword(){
        if($this->input->method() == 'post'){
            $url = null;
            $msg = null;
            $cek = $this->model_app->view_where('users',array('users_id'=>decode($this->input->post('id'))));
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
    function data(){
        if($this->input->method() == 'post'){
            $output = null;
            $output .= '<table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Level</th>
                                
                                    <th>Active</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>';
            $data = $this->model_app->view_order('users','users_id','DESC');
            if($data->num_rows() > 0){ 
                $e = __ceksesskonten('internal/users/edit');
                $h = __ceksesskonten('internal/users/hapus');
                $m = __ceksesskonten('internal/users/modul');

                $no = 1;
                foreach($data->result_array() as $row){
                    if($e){
                        $edit = "<a href='".base_url('internal/users/edit?id=').encode($row['users_id'])."' class='btn btn-icon btn-warning mx-2'><i class='feather icon-edit'></i></a>";

                    }else{
                        $edit = null;
                    }

                    if($h){
                         $hapus = "<button class='btn btn-icon btn-danger  mx-2 delete' data-id='".encode($row['users_id'])."'><i class='feather icon-trash'></i></button>";

                    }else{
                        $hapus = null;
                    }
                    if($m){
                        $modul = "<a href='".base_url('internal/users/modul?id=').encode($row['users_id'])."' class='btn btn-icon btn-info mx-2'><i class='fas fa-cogs'></i></a>";

                    }else{
                        $modul = null;
                    }

                    if($row['users_active'] == 'y'){
                        $active = 'Active';
                    }else{
                        $active = 'Not Active';
                    }
                    $output.= "<tr>
                                    <td>".$no."</td>
                                    <td>".$row['users_name']."</td>
                                    <td>".$row['users_nip']."</td>
                                    <td>".ucfirst($row['users_level'])."</td>
                                    <td>".$active."</td>
                                    <td>".$edit.$hapus.$modul."</td>


                               </tr>";
                    $no++;
                }
            }
            $output .= "</tbody>
                        </table>";
            echo json_encode($output);
        }else{
            $this->load->view('501');
        }
    }
    function store(){
        __ceksess('internal/users/add');

        if($this->input->method() == 'post'){
            $this->form_validation->set_rules('phone','Phone','min_length[10]|numeric|required|is_unique[users.users_phone]');
            $this->form_validation->set_rules('nip','NIP','min_length[10]|numeric|required|is_unique[users.users_nip]');
			$this->form_validation->set_rules('username','Username','trim|required|min_length[6]|max_length[50]|is_unique[users.users_username]');
			$this->form_validation->set_rules('name','Name','trim|required|min_length[6]|max_length[255]');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[255]');			
			$this->form_validation->set_rules('email','Email','required|is_unique[users.users_email]');
            if($this->form_validation->run() == FALSE){
                $status = false;
                $replace = array('<p>','</p>');
                $msg = replace($replace,validation_errors());
                
            }else{
                    $config['upload_path']          = './upload/users/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types']        = 'gif|jpg|png|jpeg';
					$config['max_size']             = 3000;
						
							
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('file')){
						$upload_data = $this->upload->data();
						$foto = $upload_data['file_name'];
					}else{
						$foto = 'blank.png';
					}
                $level = $this->input->post('level');
                if($level == 'admin'){
                    $sts = null;
                    $jabatan = null;
                    $data = array('users_username'=>$this->input->post('username'),
                              'users_name'=>$this->input->post('name'),
                              'users_nip'=>$this->input->post('nip'),
                              'users_email'=>$this->input->post('email'),
                              'users_password'=>$this->user_access->encrypt_md5($this->input->post('username'),$this->input->post('password')),
                              'users_phone'=>$this->input->post('phone'),
                              'users_photo'=>$foto,
                              'users_level'=>$level,
                              'users_jabatan'=>$jabatan,
                              'users_status'=>$sts,
                              
                            );
                     $this->model_app->insert('users',$data);
                     $status = true;
                     $msg = 'Admin successfully created';
                }else if($level == 'lurah'){
                    $sts = 'pns';
                    $jabatan = decode($this->input->post('jabatan'));
                    $cekJabatan = $this->model_app->view_where('jabatan',array('jabatan_id'=>$jabatan));
                    if($cekJabatan->num_rows() > 0){
                        $rowJ = $cekJabatan->row_array();
                        if($rowJ['jabatan_limit'] > $rowJ['jabatan_used']){
                            $data = array('users_username'=>$this->input->post('username'),
                            'users_name'=>$this->input->post('name'),
                            'users_nip'=>$this->input->post('nip'),
                            'users_email'=>$this->input->post('email'),
                            'users_password'=>$this->user_access->encrypt_md5($this->input->post('username'),$this->input->post('password')),
                            'users_phone'=>$this->input->post('phone'),
                            'users_photo'=>$foto,
                            'users_level'=>$level,
                            'users_jabatan'=>$jabatan,
                            'users_status'=>$sts,
                            
                            );
                            $this->model_app->insert('users',$data);

                            $dataJ = array('jabatan_used'=>$rowJ['jabatan_used']+1);
                            $this->model_app->update('jabatan',$dataJ,array('jabatan_id'=>$jabatan));
                            $status = true;
                            $msg = 'Lurah successfully created';
                        }else{
                            $status = false;
                            $msg = $rowJ['jabatan_name'].' full' ;
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Jabatan not found!';
                    }
                    
                }else if($level == 'kaling'){
                    $sts = null;
                    $jabatan = null;
                    $bjr = decode($this->input->post('banjar'));
                    $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$bjr));
                    if($banjar->num_rows() > 0){
                        $rowB = $banjar->row_array();
                        if($rowB['banjar_kaling'] == NULL){
                            $data = array('users_username'=>$this->input->post('username'),
                            'users_name'=>$this->input->post('name'),
                            'users_nip'=>$this->input->post('nip'),
                            'users_email'=>$this->input->post('email'),
                            'users_password'=>$this->user_access->encrypt_md5($this->input->post('username'),$this->input->post('password')),
                            'users_phone'=>$this->input->post('phone'),
                            'users_photo'=>$foto,
                            'users_level'=>$level,
                            'users_jabatan'=>$jabatan,
                            'users_status'=>$sts,
                            
                             );
                            $user_id = $this->model_app->insert_id('users',$data);
                            $this->model_app->update('banjar',array('banjar_kaling'=>$user_id),array('banjar_id'=>$bjr));
                            $status = true;
                            $msg = 'Kepala Lingkungan successfull created';
                        
                        }else{
                            $status = false;
                            $msg = 'Banjar have kaling now';
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Banjar not found';
                    }
                  
                }else if($level == 'pegawai'){
                    $sts = $this->input->post('status');
                    $jabatan = decode($this->input->post('jabatan'));
                    $cekJabatan = $this->model_app->view_where('jabatan',array('jabatan_id'=>$jabatan));
                    if($cekJabatan->num_rows() > 0){
                        $rowJ = $cekJabatan->row_array();
                        if($rowJ['jabatan_limit'] > $rowJ['jabatan_used']){
                            $data = array('users_username'=>$this->input->post('username'),
                            'users_name'=>$this->input->post('name'),
                            'users_nip'=>$this->input->post('nip'),
                            'users_email'=>$this->input->post('email'),
                            'users_password'=>$this->user_access->encrypt_md5($this->input->post('username'),$this->input->post('password')),
                            'users_phone'=>$this->input->post('phone'),
                            'users_photo'=>$foto,
                            'users_level'=>$level,
                            'users_jabatan'=>$jabatan,
                            'users_status'=>$sts,
                            
                            );
                            $this->model_app->insert('users',$data);

                            $dataJ = array('jabatan_used'=>$rowJ['jabatan_used']+1);
                            $this->model_app->update('jabatan',$dataJ,array('jabatan_id'=>$jabatan));
                            $status = true;
                            $msg = 'Pegawai successfully created';
                        }else{
                            $status = false;
                            $msg = $rowJ['jabatan_name'].' full' ;
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Pegawai not found!';
                    }

                }
                
               
            
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function update(){
        __ceksess('internal/users/edit');

        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() <= 0){
                $status = false;
                $replace = array('<p>','</p>');
                $msg = 'User tidak ditemukan!';
                
            }else{
                $email = $this->input->post('email');
                $row = $cek->row_array();
                $level = $this->input->post('level');
                if($level == 'admin'){
                    $sts = null;
                    $jabatan = null;
                    $cekEmail = $this->db->query("SELECT * FROM users WHERE users_email='$email' AND users_email != '$row[users_email]'");
                    if($cekEmail->num_rows() > 0){
                        $status = false;
                        $msg= 'Email telah digunakan!';
                    }else{
                    $data = array(
                              'users_name'=>$this->input->post('name'),
                              'users_nip'=>$this->input->post('nip'),
                              'users_email'=>$this->input->post('email'),
                           
                              'users_phone'=>$this->input->post('phone'),
                             
                              'users_level'=>$level,
                              'users_jabatan'=>$jabatan,
                              'users_status'=>$sts,
                              
                            );
                            $this->model_app->update('users',$data,array('users_id'=>$id));

                     $status = true;
                     $msg = 'Admin successfully created';
                    }
                }else if($level == 'lurah'){
                    $sts = 'pns';
                    $jabatan = decode($this->input->post('jabatan'));
                    $cekJabatan = $this->model_app->view_where('jabatan',array('jabatan_id'=>$jabatan));
                    if($cekJabatan->num_rows() > 0){
                        $rowJ = $cekJabatan->row_array();
                        if($rowJ['jabatan_limit'] > $rowJ['jabatan_used'] OR $row['users_jabatan'] == $jabatan){
                            $cekEmail = $this->db->query("SELECT * FROM users WHERE users_email='$email' AND users_email != '$row[users_email]'");
                            if($cekEmail->num_rows() > 0){
                                $status = false;
                                $msg= 'Email telah digunakan!';
                            }else{
                            $data = array(
                            'users_name'=>$this->input->post('name'),
                            'users_nip'=>$this->input->post('nip'),
                            'users_email'=>$this->input->post('email'),
                           
                            'users_phone'=>$this->input->post('phone'),
                           
                            'users_level'=>$level,
                            'users_jabatan'=>$jabatan,
                            'users_status'=>$sts,
                            
                            );
                            $this->model_app->update('users',$data,array('users_id'=>$id));

                            if($row['users_jabatan'] != $jabatan){
                                $cekBef = $this->model_app->view_where('jabatan',array('jabatan_id'=>$row['users_jabatan']));
                                if($cekBef->num_rows() > 0){
                                    $rowB = $cekBef->row_array();
                                    $dataB = array('jabatan_used'=>$rowB['jabatan_used']-1);
                                    $this->model_app->update('jabatan',$dataB,array('jabatan_id'=>$row['users_jabatan']));
                                }
                                $dataJ = array('jabatan_used'=>$rowJ['jabatan_used']+1);
                                $this->model_app->update('jabatan',$dataJ,array('jabatan_id'=>$jabatan));
                            }
                            
                            $status = true;
                            $msg = 'Lurah berhasil diubah';
                            }
                        }else{
                            $status = false;
                            $msg = $rowJ['jabatan_name'].' full' ;
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Jabatan not found!';
                    }
                    
                }else if($level == 'kaling'){
                    $sts = null;
                    $jabatan = null;
                    $bjr = decode($this->input->post('banjar'));
                    $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$bjr));
                    if($banjar->num_rows() > 0){
                        $rowB = $banjar->row_array();
                        
                        if($rowB['banjar_kaling'] == NULL OR $rowB['banjar_kaling'] == $row['users_id']){
                            $cekEmail = $this->db->query("SELECT * FROM users WHERE users_email='$email' AND users_email != '$row[users_email]'");
                            if($cekEmail->num_rows() > 0){
                                $status = false;
                                $msg= 'Email telah digunakan!';
                            }else{
                                $data = array(
                                'users_name'=>$this->input->post('name'),
                                'users_nip'=>$this->input->post('nip'),
                                'users_email'=>$this->input->post('email'),
                            
                                'users_phone'=>$this->input->post('phone'),
                                
                                'users_level'=>$level,
                                'users_jabatan'=>$jabatan,
                                'users_status'=>$sts,
                                
                                );
                                $this->model_app->update('users',$data,array('users_id'=>$id));

                                $this->model_app->update('banjar',array('banjar_kaling'=>$id),array('banjar_id'=>$bjr));
                                $status = true;
                                $msg = 'Kepala Lingkungan berhasil diubah';
                            }
                        
                        }else{
                            $status = false;
                            $msg = 'Banjar sudah memiliki kaling';
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Banjar not found';
                    }
                  
                }else if($level == 'pegawai'){
                    $sts = $this->input->post('status');
                    $jabatan = decode($this->input->post('jabatan'));
                    $cekJabatan = $this->model_app->view_where('jabatan',array('jabatan_id'=>$jabatan));
                    if($cekJabatan->num_rows() > 0){
                        $rowJ = $cekJabatan->row_array();
                        if($rowJ['jabatan_limit'] > $rowJ['jabatan_used'] OR $row['users_jabatan'] == $jabatan){
                            $cekEmail = $this->db->query("SELECT * FROM users WHERE users_email='$email' AND users_email != '$row[users_email]'");
                            if($cekEmail->num_rows() > 0){
                                $status = false;
                                $msg= 'Email telah digunakan!';
                            }else{
                                $data = array('users_username'=>$this->input->post('username'),
                                'users_name'=>$this->input->post('name'),
                                'users_nip'=>$this->input->post('nip'),
                                'users_email'=>$this->input->post('email'),
                            
                                'users_phone'=>$this->input->post('phone'),
                            
                                'users_level'=>$level,
                                'users_jabatan'=>$jabatan,
                                'users_status'=>$sts,
                                
                                );
                                $this->model_app->update('users',$data,array('users_id'=>$id));

                                if($row['users_jabatan'] != $jabatan){
                                    $cekBef = $this->model_app->view_where('jabatan',array('jabatan_id'=>$row['users_jabatan']));
                                    if($cekBef->num_rows() > 0){
                                        $rowB = $cekBef->row_array();
                                        $dataB = array('jabatan_used'=>$rowB['jabatan_used']-1);
                                        $this->model_app->update('jabatan',$dataB,array('jabatan_id'=>$row['users_jabatan']));
                                    }
                                    

                                    $dataJ = array('jabatan_used'=>$rowJ['jabatan_used']+1);
                                    $this->model_app->update('jabatan',$dataJ,array('jabatan_id'=>$jabatan));
                                }
                                $status = true;
                                $msg = 'Pegawai berhasil diubah';
                            }
                        }else{
                            $status = false;
                            $msg = $rowJ['jabatan_name'].' full' ;
                        }
                       
                    }else{
                        $status = false;
                        $msg = 'Pegawai not found!';
                    }

                }
                
               
            
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function modul(){
        __ceksess('internal/users/modul');

        if($this->input->method() == 'get' && $this->input->get('id') != null){
            $id = decode($this->input->get('id'));
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            if($cek->num_rows() > 0){
                $data['row'] = $cek->row_array();
                $data['title'] = 'Internal Kelurahan Renon';
                $data['page'] = 'Users';
                $data['header'] = 'Modul Users';
                $data['breadcrumb'] = '<li class="breadcrumb-item"><a href="'.base_url('internal/users').'">User</a></li>';
                $data['breadcrumb'] .= '<li class="breadcrumb-item"><a >Modul</a></li>';
                $data['js'] = base_url('template/admin/ajax/user/ajax-users-modul.js');
                $this->template->load('template','mod_users/view_users_modul',$data);
            }else{
                $this->session->set_flashdata('message', 'Users tidak ditemukan!');
                redirect('internal/users');
            }
        }else{
            $this->load->view('501');
        }
    }
    function dataModul(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            $output = null;
            $msg = null;
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $status = true;
                $modul = $this->model_app->view_where_ordering('modul',array('modul_visible'=>'y'),'modul_name','ASC');
                if($modul->num_rows() > 0){
                    foreach($modul->result_array() as $mod){
                        $output .=  "<div class='col-md-6'>
                                    <div class='row'> 
                                        <div class='col-md-12 mb-2'><h6>".$mod['modul_name']."</h6></div>
                                        <div class='col-md-12 mb-2'>
                                            <span style='display:block'><input name='checkboxes' class='checkboxes' type='checkbox' target='".str_replace(' ','_',strtolower($mod['modul_name']))."' /> Check all</span> 

                                            
                                        </div>
                                        ";
                        $submodul = $this->model_app->view_where('submodul',array('submodul_modul_id'=>$mod['modul_id'],'submodul_visible'=>'y'));
                        if($submodul->num_rows() > 0){
                            foreach($submodul->result_array() as $sub){
                                 $mods = $this->model_app->view_where('users_modul',array('umod_submodul_id'=>$sub['submodul_id'],'umod_users_id'=>$row['users_id']));
                                 if($mods->num_rows() == 0){
                                     $output .= "<div class='col-md-12'>
                                                    <span style='display:block'><input name='modul[]' type='checkbox' class='".str_replace(' ','_',strtolower($mod['modul_name']))."' value='".$sub['submodul_modul_id'].'|'.$sub['submodul_id']."' /> ". $sub['submodul_name'] ."</span> 
                                                </div>";
                                 }
        
                            }
                        }
                        $output .= "       </div>
                              </div>";
                    }
                    $output .= "<div class='col-md-12'><button class='btn btn-primary float-right'>Simpan</button></div>";
                }
            }else{
                $status = false;
                $msg = 'Users tidak ditemukan!';
            }
            echo json_encode(array('output'=>$output,'msg'=>$msg,'status'=>$status));
        }else{
            $this->load->view('501');
        }
       
    }
    function storeModul(){
        
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            if(count($this->input->post('modul')) > 0){
                $cek = $this->model_app->view_where('users',array('users_id'=>$id));
                if($cek->num_rows() > 0){
                    $row = $cek->row_array();
                        $mod=count($this->input->post('modul'));
                        $modul=$this->input->post('modul');
                        for($i=0;$i<$mod;$i++){
                          
                            $modus = explode('|',$modul[$i]);
                            $sub = $modus[1];
                            $modu = $modus[0];
                           
                            $datam = array('umod_users_id'=>$row['users_id'],
                                        'umod_modul_id'=>$modu,'umod_submodul_id'=>$sub);
                        
                            $this->model_app->insert('users_modul',$datam);
                        }
                    $status = true;
                    $msg ='Modul Berhasil Ditambahkan';
                }else{
                    $msg ='User tidak ditemukan';
                    $status = false;
                }
            }else{
                $status = false;
                $msg = 'Tidak ada modul yang dipilih';
            }
            
            echo json_encode(array('status'=>$status,'msg'=>$msg));
        }else{
            $this->load->view('501');
        }
    }
    function dataModulUsers(){
        if($this->input->method() == 'post'){
            $id = decode($this->input->post('id'));
            $cek = $this->model_app->view_where('users',array('users_id'=>$id));
            $output = null;
            $msg = null;
            if($cek->num_rows() > 0){
                $row = $cek->row_array();
                $status = true;
                $modul = $this->model_app->view_where_ordering('modul',array('modul_visible'=>'y'),'modul_name','ASC');
                if($modul->num_rows() > 0){
                    foreach($modul->result_array() as $mod){
                        $cekMods = $this->model_app->view_where('users_modul',array('umod_users_id'=>$row['users_id'],'umod_modul_id'=>$mod['modul_id']));
                        if($cekMods->num_rows() > 0){
                            $output .=  "<div class='col-md-4 my-2'>
                                    <div class='row'> 
                                        <div class='col-md-12 mb-2'><h6>".$mod['modul_name']."</h6></div>
                                        <div class='col-md-12 mb-2'>
                                          

                                            
                                        </div>
                                            ";
                            $submodul = $this->model_app->view_where('submodul',array('submodul_modul_id'=>$mod['modul_id']));
                            if($submodul->num_rows() > 0){
                                foreach($submodul->result_array() as $sub){
                                    $mods = $this->model_app->view_where('users_modul',array('umod_submodul_id'=>$sub['submodul_id'],'umod_users_id'=>$row['users_id']));
                                    if($mods->num_rows() > 0){
                                        $umod = $mods->row_array();
                                        $output .= "<div class='col-md-8'>
                                                        <span style='display:block'>". $sub['submodul_name'] ."</span> 
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <span class='feather icon-trash text-danger __delakses' data-id='".encode($umod['umod_id'])."' title='Hapus Akses'></span>
                                                    </div>
                                                    ";
                                    }
            
                                }
                            }
                            $output .= "       </div>
                                </div>";
                        }
                        
                        
                    }
                }
            }else{
                $status = false;
                $msg = 'Users tidak ditemukan!';
            }
            echo json_encode(array('output'=>$output,'msg'=>$msg,'status'=>$status));
        }else{
            $this->load->view('501');
        }
       
    }
    function deleteAkses(){
        if($this->input->method() == 'post' AND $this->input->post('id') AND $this->input->post('umod')){
            $id = decode($this->input->post('id'));
            $umod = decode($this->input->post('umod'));
            $cek = $this->model_app->view_where('users_modul',array('umod_users_id'=>$id,'umod_id'=>$umod));
            if($cek->num_rows() > 0){
                $this->model_app->delete('users_modul',array('umod_id'=>$umod));
                $status = true;
                $msg = 'Akses berhasil dihapus';
            }else{
                $status = false;
                $msg = 'Akses tidak ditemukan';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg));
            
        }else{
            $this->load->view('501');
        }
    }


    

    

}
