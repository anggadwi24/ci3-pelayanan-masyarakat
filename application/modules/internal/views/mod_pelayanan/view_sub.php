<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-11"><h5><?= $header?></h5></div>
                <div class="col-1">
                    <?php $add = __ceksesskonten('internal/subpelayanan/add');
                    if($add){?>
                     <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/subpelayanan/add')?>">
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
                            <th>Pelayanan</th>
                            <th>Sub Pelayanan</th>
                            <th>Dibuat oleh</th>
                            <th>Tanggal Dibuat</th>
                            

                            
                            
                            <th>#</th>
                        </tr>
                    </thead>
                    <?php if($record->num_rows() > 0 ){
                        $no = 1;
                        foreach($record->result_array() as $row){
                            $edit = __ceksesskonten('internal/subpelayanan/edit');
                            $hapus = __ceksesskonten('internal/subpelayanan/delete');
                            $user = $this->model_app->view_where('users',array('users_id'=>$row['subpel_created_by']))->row_array();
                            echo  "<tr>
                                    <td>".$no."</td>
                                    <td>".$row['pelayanan_name']."</td>
                                    <td>".$row['subpel_name']."</td>
                                    <td>".$user['users_name']."</td>
                                    <td>".tanggal($row['pelayanan_created_on'])."</td>
                                    
                                    <td>
                                        ";
                                        if($edit){
                                            echo " <a class='btn btn-primary btn-icon btn-sm edit' href='".base_url('internal/subpelayanan/edit?id=').encode($row['subpel_id'])."' >
                                            <i class='feather icon-edit'></i>
                                        </a>";
                                        }else{
                                            echo "";
                                        }
                                        if($hapus){
                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/subpelayanan/delete?id=').encode($row['subpel_id'])."'>
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