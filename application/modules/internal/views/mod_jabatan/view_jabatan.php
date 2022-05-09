<div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-11"><h5><?= $header?></h5></div>
                                                <div class="col-1">
                                                <?php $add = __ceksesskonten('internal/jabatan/add');
                                                    if($add){?>
                                                   <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/jabatan/add')?>">
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
                                                            <th>Jabatan</th>
                                                            <th>Used/Limit</th>
                                                            

                                                           
                                                           
                                                            <th>#</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if($record->num_rows() > 0 ){
                                                        $no = 1;
                                                        foreach($record->result_array() as $row){
                                                            $edit = __ceksesskonten('internal/jabatan/edit');
                                                            $hapus = __ceksesskonten('internal/jabatan/hapus');

                                                            echo  "<tr>
                                                                    <td>".$no."</td>
                                                                    <td>".$row['jabatan_name']."</td>
                                                                    <td>".$row['jabatan_used']." / ".$row['jabatan_limit']."</td>
                                                                    <td>
                                                                        ";
                                                                        if($edit){
                                                                            echo " <a class='btn btn-primary btn-icon btn-sm' href='".base_url('internal/jabatan/edit?id='.encode($row['jabatan_id']))."'>
                                                                            <i class='feather icon-edit'></i>
                                                                        </a>";
                                                                        }else{
                                                                            echo "";
                                                                        }
                                                                        if($hapus){
                                                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/jabatan/delete?id=').encode($row['jabatan_id'])."'>
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