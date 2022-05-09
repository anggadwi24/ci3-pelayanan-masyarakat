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
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?= $header?></h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="formMod">
                                                <div class="row" id="__datamodul">
                                                
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?= $header?></h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="row" id="__datamodulmu">
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>