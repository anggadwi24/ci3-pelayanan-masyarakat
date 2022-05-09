                            <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-10"><h5><?= $header?></h5></div>
                                                <div class="col-2">
                                                    <?php $add = __ceksesskonten('internal/users/add');
                                                    if($add){?>
                                                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/users/add')?>">
                                                        <i class="feather icon-plus"></i>
                                                    </a>
                                                    <?php }?>
                                                    <button class="btn btn-outline-primary btn-icon btn-sm" id="refresh">
                                                        <i class="feather icon-refresh-ccw"></i>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive" id="table">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ configuration table ] end -->