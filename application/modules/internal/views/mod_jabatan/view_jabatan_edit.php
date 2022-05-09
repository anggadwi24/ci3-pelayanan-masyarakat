<div class="col-sm-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-tile">Users Jabatan <?= $row['jabatan_name']?></h5>
        </div>
        <div class="card-block">
            <div class="row">
                <?php 
                    $users = $this->model_app->view_where('users',array('users_jabatan'=>$row['jabatan_id']));
                    if($users->num_rows() > 0){
                        foreach($users->result_array() as $us){
                            echo "<div class='col-sm-12'><h6>".$us['users_name']."</h6></div>";
                        }
                    }else{
                        echo "<div class='col-sm-12'><h6>Tidak ada users</h6></div>";
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
            <form action="<?= base_url('internal/jabatan/update') ?>" method="post">
                <div class="row">
                   <div class="col-md-6 form-group">
                       <label for="">Jabatan Name</label>
                       <input type="text" name="name" class="form-control" value="<?= $row['jabatan_name'] ?>" required>
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="">Jabatan Limit</label>
                       <input type="number" name="limit" class="form-control" value="<?= $row['jabatan_limit'] ?>" required>
                   </div>
                   <div class="col-md-12 form-group">`
                       <input type="hidden" name="id" value="<?= encode($row['jabatan_id'])?>">
                       <button class="btn btn-primary float-right">Simpan</button>
                   </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>