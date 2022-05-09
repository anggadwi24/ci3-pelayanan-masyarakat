<?php 
                                if($row['users_level'] == 'admin'){
                                    $jabatan = '';
                                }else if($row['users_level'] == 'pegawai' OR $row['users_level'] == 'lurah'){
                                    $jbt = $this->model_app->view_where('jabatan',array('jabatan_id'=>$row['users_jabatan']))->row_array();
                                    $jabatan = '<h6>Jabatan : '.ucfirst($jbt['jabatan_name']).'</h6>';
                                }else{
                                    $bnjr = $this->model_app->view_where('banjar',array('banjar_kaling'=>$row['users_id']))->row_array();
                                    $jabatan = '<h6> Jabatan : '.ucfirst($row['users_level'].' '.$bnjr['banjar_name']).'</h6>';
                                }
                              
                              ?>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Profile</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row">
                                                    <div class="col-md-12 mx-auto text-center form-group">
                                                    <?php if(file_exists('upload/users/'.$row['users_photo'])){
                                                        echo '<img src="'.base_url('upload/users/').$row['users_photo'].'" id="profilePhoto" class="img-fluid rounded-circle" style="width:150px;height:150px;">';
                                                    }else{
                                                        echo '<img src="'.base_url('upload/users/blank.png').'" id="profilePhoto" class="img-fluid rounded-circle" style="width:150px;height:150px;">';

                                                    }?>
                                                    </div>
                                                   
                                                    <div class="col-md-12 mt-3 text-center">
                                                        <h6>Username : <?= $row['users_username']?></h6>
                                                        <h6>Nama : <?= $row['users_name'] ?></h6>
                                                        <h6>NIP : <?= $row['users_nip'] ?></h6>
                                                        <?= $jabatan ?>


                                                    </div>
                                                
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                         
                                            <input type="file" style="display:none" accept="image/*" id="fileUp">
                                            <button class="btn btn-primary btn-sm btn-icon float-left" id="btnFile" title="Ganti Fo Profile"><i class="feather icon-image"></i></button>
                                        
                                            
                                            <button class="btn btn-primary btn-sm btn-icon float-right" type="button"  data-toggle="modal" data-target="#modalChange" ><i class="feather icon-lock"></i></button>
                                              
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?= $header?></h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="formEdit">
                                                <div class="row">
                                                   
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NIP</label>
                                                            <input type="number" class="form-control" name="nip" placeholder="NIP" required  value="<?= $row['users_nip'] ?>">
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name.." required  value="<?= $row['users_name'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="Email" required  value="<?= $row['users_email'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Phone</label>
                                                            <input type="number" class="form-control" name="phone" placeholder="6287888888" required  value="<?= $row['users_phone'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                         <button type="submit" class="btn btn-primary float-right">Save</button>
                                                    </div>
                                                   
                                                
                                                 
                                                  
                                                    
                                                </div>
                                               
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalChange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Change Password</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form id="formPass">
                                            <div class="modal-body">
                                                
                                                    <div class="form-group">
                                                        <label for="">Password</label>
                                                        <input type="password" class="form-control" name="password" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Re-password</label>
                                                        <input type="password" class="form-control" name="repassword" required>
                                                    </div>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
