<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-11"><h5><?= $header?></h5></div>
                <div class="col-1">
                    <?php $add = __ceksesskonten('internal/pelayanan/add');
                    if($add){?>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                     &nbsp;&nbsp;<i class="feather icon-plus"></i>
                    </button>
                    
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
                            <th>Dibuat oleh</th>
                            <th>Tanggal Dibuat</th>
                            

                            
                            
                            <th>#</th>
                        </tr>
                    </thead>
                    <?php if($record->num_rows() > 0 ){
                        $no = 1;
                        foreach($record->result_array() as $row){
                            $edit = __ceksesskonten('internal/pelayanan/edit');
                            $hapus = __ceksesskonten('internal/pelayanan/delete');
                            $user = $this->model_app->view_where('users',array('users_id'=>$row['pelayanan_created_by']))->row_array();
                            echo  "<tr>
                                    <td>".$no."</td>
                                    <td>".$row['pelayanan_name']."</td>
                                    <td>".$user['users_name']."</td>
                                    <td>".tanggal($row['pelayanan_created_on'])."</td>
                                    
                                    <td>
                                        ";
                                        if($edit){
                                            echo " <button class='btn btn-primary btn-icon btn-sm edit' data-id='".encode($row['pelayanan_id'])."' >
                                            <i class='feather icon-edit'></i>
                                        </button>";
                                        }else{
                                            echo "";
                                        }
                                        if($hapus){
                                            echo "<button class='btn btn-danger btn-icon btn-sm delete' data-href='".base_url('internal/pelayanan/delete?id=').encode($row['pelayanan_id'])."'>
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
<?php if($add){?>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pelayanan </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('internal/pelayanan/store')?>" method="POST">
      <div class="modal-body">
        <div class="row">
            <div class="col-12 form-group">
                <label for="">Pelayanan</label>
                <input type="text" class="form-control" name="pelayanan" required placeholder="Nama Pelayanan">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
  <?php }?>
  <?php 
  $editt = __ceksesskonten('internal/pelayanan/edit');
  if($editt){?>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pelayanan </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('internal/pelayanan/update')?>" method="POST">
      <div class="modal-body">
        <div class="row">
            <div class="col-12 form-group">
                <label for="">Pelayanan</label>
                <input type="text" class="form-control" name="pelayanan" id="pelayanan" required placeholder="Nama Pelayanan">
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" id="id" name="id">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
  </div>
  <?php }?>