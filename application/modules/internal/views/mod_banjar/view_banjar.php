<div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-11"><h5><?= $header?></h5></div>
                                                <div class="col-1">
                                                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/banjar/add')?>">
                                                        <i class="feather icon-plus"></i>
                                                    </a>
                                                   
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive" id="table">
                                               
                                                <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Banjar</th>
                                                            <th>Kaling</th>
                                                            

                                                           
                                                           
                                                            <th>#</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if($record->num_rows() > 0 ){
                                                        $no = 1;
                                                        foreach($record->result_array() as $row){
                                                            $edit = __ceksesskonten('internal/banjar/edit');
                                                            $hapus = __ceksesskonten('internal/banjar/hapus');
                                                            if($row['banjar_kaling'] == NULL){
                                                                $kaling = 'Belum ada';
                                                            }else{
                                                                $user = $this->model_app->view_where('users',array('users_id'=>$row['banjar_kaling']));
                                                                if($user->num_rows() > 0){
                                                                    $us = $user->row_array();
                                                                    $kaling = $us['users_name'];
                                                                }else{
                                                                    $kaling = 'Kaling tidak ditemukan';
                                                                }
                                                            }
                                                            echo  "<tr>
                                                                    <td>".$no."</td>
                                                                    <td>".$row['banjar_name']."</td>
                                                                    <td>".$kaling."</td>
                                                                    <td>
                                                                        ";
                                                                        if($edit){
                                                                            echo " <a class='btn btn-primary btn-icon btn-sm' href='".base_url('internal/banjar/edit?id='.encode($row['banjar_id']))."'>
                                                                            <i class='feather icon-edit'></i>
                                                                        </a>";
                                                                        }else{
                                                                            echo "";
                                                                        }
                                                                        if($hapus){
                                                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/banjar/delete?id=').encode($row['banjar_id'])."'>
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