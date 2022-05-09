<div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-11"><h5><?= $header?></h5></div>
                                                <div class="col-1">
                                                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/modul/add')?>">
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
                                                            <th>Urutan</th>
                                                            <th>Modul</th>
                                                            <th>Icon</th>
                                                           
                                                           
                                                            <th>#</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if($record->num_rows() > 0 ){
                                                        $no = 1;
                                                        $edit = __ceksesskonten('internal/modul/edit');
                                                        $hapus = __ceksesskonten('internal/modul/delete');
                                                        foreach($record->result_array() as $row){
                                                            echo  "<tr>
                                                                    <td>".$row['modul_order']."</td>
                                                                    <td>".$row['modul_name']."</td>
                                                                    <td><i class='".$row['modul_icon']."'></i></td>
                                                                    <td>
                                                                    ";
                                                            if($edit){
                                                                echo "  <a class='btn btn-primary btn-icon btn-sm' href='".base_url('internal/modul/edit?id='.encode($row['modul_id']))."'>
                                                                <i class='feather icon-edit'></i>
                                                            </a>";
                                                            }
                                                            if($hapus){
                                                                echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/modul/delete?id=').encode($row['modul_id'])."'>
                                                                <i class='feather icon-trash'></i>
                                                            </button>";
                                                            }
                                                                      
                                                                        
                                                                echo "    </td>
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