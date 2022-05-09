<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-11"><h5><?= $header?></h5></div>
                <div class="col-1">
                    <?php  $add = __ceksesskonten('internal/foto/add');
                            if($add){
                    ?>
                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/foto/add')?>">
                        <i class="feather icon-plus"></i>
                    </a>
                    <?php }?>
                    
                </div>
                
            </div>
            
        </div>
        <div class="card-block">
            <div class="table-responsive" id="table">
                
                <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Tanggal Dibuat</th>
                            <th>View</th>
                            <th>Dibuat Oleh</th>
                            

                            
                            
                            <th>#</th>
                        </tr>
                    </thead>
                    <?php if($record->num_rows() > 0 ){
                        $no = 1;
                        foreach($record->result_array() as $row){
                            $edit = __ceksesskonten('internal/foto/edit');
                            $hapus = __ceksesskonten('internal/foto/delete');
                            $user =$this->model_app->view_where('users',array('users_id'=>$row['gal_created_by']))->row_array();
                            echo  "<tr>
                                    <td>".$no."</td>
                                    <td>".$row['gal_title']."</td>
                                    
                                    <td>".tanggal($row['gal_date'])."</td>
                                    <td>".$row['gal_views']." views</td>
                                    <td>".ucfirst($user['users_name'])."</td>
                                  
                                    <td>
                                        ";
                                        if($edit){
                                            echo " <a class='btn btn-primary btn-icon btn-sm' href='".base_url('internal/foto/edit?id='.encode($row['gal_id']))."'>
                                            <i class='feather icon-edit'></i>
                                        </a>";
                                        }else{
                                            echo "";
                                        }
                                        if($hapus){
                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/foto/delete?id=').encode($row['gal_id'])."'>
                                            <i class='feather icon-trash'></i>
                                        </button>";
                                        }else{
                                            echo "";
                                        }
                            echo "
                                        
                                    </td>
                                    </tr>";
                            $no++;
                        }
                    
                    }?>
                    <tbody>
                </table>
                
            </div>
        </div>
    </div>
    </div>