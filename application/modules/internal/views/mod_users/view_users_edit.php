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
                                                            <label class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="username" placeholder="Username" disabled required value="<?= $row['users_username'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NIP</label>
                                                            <input type="number" class="form-control" name="nip" placeholder="NIP" required  value="<?= $row['users_nip'] ?>">
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" placeholder="Name.." required  value="<?= $row['users_name'] ?>">
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Level</label>
                                                            <select class="form-control" name="level" id="level">>
                                                                <option disabled selected>Select level...</option>
                                                                <option value="pegawai">Pegawai</option>
                                                                <option value="kaling">Kepala Lingkungan</option>
                                                                <option value="lurah">Lurah</option>
                                                                <option value="admin">Admin</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="formStatus" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">>
                                                                <option disabled selected>Select status...</option>
                                                                <option value="kontrak">Kontrak</option>
                                                                <option value="pns">PNS</option>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="formBanjar" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Banjar</label>
                                                            <select class="form-control" name="banjar" >>
                                                                <option disabled selected>Select banjar...</option>
                                                                <?php 
                                                                    $banjar = $this->model_app->view_where('banjar',array('banjar_kaling'=>NULL));
                                                                    $meBjr = $this->model_app->view_where('banjar',array('banjar_kaling'=>$row['users_id']))->row_array();
                                                                    if($row['users_level'] == 'kaling'){
                                                                        echo "<option value='".encode($meBjr['banjar_id'])."' selected>".$meBjr['banjar_name']."</option>";
                                                                    }

                                                                    if($banjar->num_rows() > 0){
                                                                        foreach($banjar->result_array() as $bjr){
                                                                            echo "<option value='".encode($bjr['banjar_id'])."'>".$bjr['banjar_name']."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="levelUser" value="<?= $row['users_level']?>">
                                                    <div class="col-md-6" id="formJabatan" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Jabatan</label>
                                                            <select class="form-control" name="jabatan" id="jabatan">
                                                                <option disabled selected>Select jabatan...</option>
                                                                <?php 
                                                                    $jabatan = $this->model_app->view_order('jabatan','jabatan_name','DESC');
                                                                    if($jabatan->num_rows() > 0){
                                                                        foreach($jabatan->result_array() as $jbt){
                                                                            if($row['users_level'] == 'pegawai' OR $row['users_level'] == 'lurah'){
                                                                                if($jbt['jabatan_id'] == $row['users_jabatan']){
                                                                                    echo "<option value='".encode($jbt['jabatan_id'])."' selected>".$jbt['jabatan_name']."</option>";
                                                                                }
                                                                            }
                                                                            
                                                                            if($jbt['jabatan_limit'] > $jbt['jabatan_used']){
                                                                                echo "<option value='".encode($jbt['jabatan_id'])."'>".$jbt['jabatan_name']."</option>";
                                                                            }
                                                                           
                                                                        }
                                                                    }
                                                                ?>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                 
                                                  
                                                    
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
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
<script>
    $('#status').val('<?= $row['users_status'] ?>').change();
</script>