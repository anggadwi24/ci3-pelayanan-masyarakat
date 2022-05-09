<div class="col-sm-12">
        <form id="formAdd">
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
                            
                           
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-sm-8" >
                <div class="card">
                    <div class="card-header"><h5>Form <?= $sub['subpel_name']?></h5></div>
                    <div class="card-block" >
                       
                        <div class="row" id="content">
                            
                            
                        </div>
                       
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right" id="btnPengajuan" >Complete</button>
                    </div>
                </div>
            </div>
            
           
          
            </form>
        </div>

   
</div>
    