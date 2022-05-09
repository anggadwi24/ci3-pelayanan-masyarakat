
<section class="binduz-er-main-posts-area">
    <div class=" container">
       
            <div class="row ">
            
            <div class="col-xl-4 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                <div class="card border-0 " style="background-color:#f1f1f1">
                    
                    <div class="card-body">
                    
                       <div class="row g-3">
                           <div class="col-12 ">
                                <h5 class="card-title">Detail</h5>
                           </div>
                           
                            <div class="col-12 ">
                                <label class="form-label">Pemohon</label>
                                <h6> <?= $temp['temp_nik']?> - <?= $temp['temp_fullname'] ?></h6>
                            </div>
                            <div class="col-12 ">
                                <label class="form-label">Email Pemohon</label>
                                <h6><?= $row['pm_email'] ?></h6>
                            </div>
                            <div class="col-12 ">
                                <label class="form-label">Pelayanan</label>
                                <h6><?= $pel['pelayanan_name'] ?> - <?= $sub['subpel_name']?></h6>
                            </div>
                            <div class="col-12 ">
                                <label class="form-label">Banjar</label>
                                <h6><?= $banjar['banjar_name']?></h6>
                            </div>
                        </div>
                       
                    </div>
                </div>

            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <div class="card border-0">
                    
                    <div class="card-body">
                        <form id="formAdd">
                            <div class="row g-3">
                            <div class="col-12 ">
                                    <h5 class="card-title">Form <?= $sub['subpel_name']?>  </h5>
                            </div>
                                <div class="col-12 my-3">
                                    <div class="row g-4" id="content"></div>
                                </div>
                                <div class="col-6  my-3">
                                    <?= $widget ?>
                                    <?= $script ?>
                                </div>
                                <div class="col-6 form-grouup mt-5">
                                    <button class="btn btn-primary  float-end" id="btnDone">COMPLETED</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
        
    </div>
</section>
