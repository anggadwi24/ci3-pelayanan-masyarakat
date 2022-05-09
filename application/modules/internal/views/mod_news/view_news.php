<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-11"><h5><?= $header?></h5></div>
                <div class="col-1">
                    <?php  $add = __ceksesskonten('internal/berita/add');
                            if($add){
                    ?>
                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/berita/add')?>">
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
                            <th>Judul</th>
                            <th>Category</th>
                            <th>Publish</th>
                            <th>Dibuat Oleh</th>
                            

                            
                            
                            <th>#</th>
                        </tr>
                    </thead>
                    <?php if($record->num_rows() > 0 ){
                        $no = 1;
                        foreach($record->result_array() as $row){
                            $cat = null;
                            $edit = __ceksesskonten('internal/berita/edit');
                            $hapus = __ceksesskonten('internal/berita/delete');
                            $config = __ceksesskonten('internal/berita/setting');
                            $detail = __ceksesskonten('internal/berita/detail');


                            $user =$this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
                            $category = $this->model_app->join_where_order2('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']),'bc_id','DESC');
                            foreach($category->result_array() as $catt){
                                $cat .= "<span class='badge badge-pill badge-primary mx-1'>".$catt['cat_category']."</span>";
                            }
                            if(strlen($row['berita_title']) > 30){
                                $title = substr($row['berita_title'],0,30)."...";
                            }else{
                                $title = $row['berita_title'];
                            }

                            if($row['berita_publish'] == 'y'){
                                $pub = tanggal($row['berita_publish_on']);
                            }else{
                                $pub= 'Tidak publish';
                            }
                            echo  "<tr>
                                    <td>".$no."</td>
                                    <td title='".$row['berita_title']."'>".$title."</td>
                                    <td>".$cat."</td>

                                    <td>".$pub."</td>
                                    <td>".ucfirst($user['users_name'])."</td>
                                  
                                    <td>
                                        ";
                                        if($detail){
                                            echo "<a href='".base_url('internal/berita/detail?id='.encode($row['berita_id']))."' class='btn btn-primary btn-icon btn-sm' title='Detail'><i class='feather icon-eye'></i></a>";
                                        }else{
                                            echo " ";
                                        }
                                        if($edit){
                                            echo " <a class='btn btn-warning btn-icon btn-sm' href='".base_url('internal/berita/edit?id='.encode($row['berita_id']))."'>
                                            <i class='feather icon-edit'></i>
                                        </a>";
                                        }else{
                                            echo "";
                                        }
                                        if($hapus){
                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/berita/delete?id=').encode($row['berita_id'])."'>
                                            <i class='feather icon-trash'></i>
                                        </button>";
                                        }else{
                                            echo "";
                                        }
                                        if($config){
                                            echo "<button class='btn btn-info btn-icon btn-sm config' data-href='".base_url('internal/berita/delete?id=').encode($row['berita_id'])."'>
                                            <i class='feather icon-settings'></i>
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