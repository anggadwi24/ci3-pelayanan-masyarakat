<div class="col-sm-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-tile">Kaling Banjar <?= $row['banjar_name']?></h5>
        </div>
        <div class="card-block">
            <div class="row">
                <?php 
                    $users = $this->model_app->view_where('users',array('users_id'=>$row['banjar_kaling']));
                    if($users->num_rows() > 0){
                       $rowUser = $users->row_array();
                            echo '   <div class="col-md-12 mx-auto text-center form-group">
                           '; if(file_exists('upload/users/'.$rowUser['users_photo'])){
                                echo '<img src="'.base_url('upload/users/').$rowUser['users_photo'].'" id="profilePhoto" class="img-fluid rounded-circle" style="width:150px;height:150px;">';
                            }else{
                                echo '<img src="'.base_url('upload/users/blank.png').'" id="profilePhoto" class="img-fluid rounded-circle" style="width:150px;height:150px;">';

                            }
                            echo '  </div>
                                    <div class="col-md-12 mt-3 text-center">
                                        <h6>Nama : '.$rowUser['users_name'].'</h6>
                                        <h6>NIP : '.$rowUser['users_nip'].'</h6>
                                        
                                    </div>
                                
                            </div>' ;
                        
                    }else{
                        echo "<div class='col-sm-12'><h6>Banjar tidak memiliki kaling</h6></div>";
                    }

                ?>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $header ?></h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/banjar/update') ?>" method="post">
                <div class="row">
                <div class="col-md-6 form-group">
                       <label for="">Banjar Name</label>
                       <input type="text" name="name" class="form-control" required value="<?= $row['banjar_name']?>">
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="">Banjar Address</label>
                       <input type="text" name="address" class="form-control" required value="<?= $row['banjar_address']?>">
                   </div>
                   <div class="col-md-12 form-group">
                       <input type="hidden" name="id" value="<?= encode($row['banjar_id']) ?>">
                       <button class="btn btn-primary float-right">Simpan</button>
                   </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>