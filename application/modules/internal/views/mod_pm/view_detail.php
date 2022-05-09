<div class="col-sm-12">
      
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header"><h5 style="font-size:15px;"><?=$header?></h5></div>
                    <div class="card-block">
                   
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="">No Pengajuan</label>
                                <h6><?= $row['pm_no'] ?></h6>
                            </div> 
                            <div class="col-12 form-group">
                                <label for="">Pemohon</label>
                                <h6> <?= $temp['temp_nik']?> - <?= $temp['temp_fullname'] ?></h6>
                            </div>
                            <div class="col-12 form-group">
                                <label for="">Email Pemohon</label>
                                <h6><?= $row['pm_email'] ?></h6>
                            </div>
                            <div class="col-12 form-group">
                                <label for="">Pelayanan</label>
                                <h6><?= $pel['pelayanan_name'] ?> - <?= $sub['subpel_name']?></h6>
                            </div>
                            <div class="col-12 form-group">
                                <label for="">Banjar</label>
                                <h6><?= $banjar['banjar_name']?></h6>
                            </div>
                            <div class="col-12 form-group">
                                
                                <button class="float-right btn btn-icon btn-info img" data-src="<?= base_url('upload/identity/'.$row['pm_identity']) ?>"> <i class="fas fa-id-card"></i></button>
                            </div>
                           
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-sm-8" >
                <div class="card">
                    <div class="card-header"><h5>Detail <?= $sub['subpel_name']?></h5></div>
                    <div class="card-block" >
                       
                        <div class="row" id="content">
                            
                            
                        </div>
                        <div class="row" id="approve">
                            
                        </div>
                       
                    </div>
                    
                </div>
            </div>
            
           
          
          
        </div>

   
</div>
    