<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-9"><h5><?= $header?></h5></div>
                <div class="col-3">
                    <?php $add = __ceksesskonten('internal/administrasi/add');
                    if($add){?>
                    <a class="btn btn-primary btn-icon btn-sm" href="<?= base_url('internal/administrasi/add')?>">
                        <i class="feather icon-plus"></i>
                    </a>
                    <?php }?>
                    <button class="btn btn-outline-primary btn-icon btn-sm" id="refresh">
                        <i class="feather icon-refresh-ccw"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-icon btn-sm" data-toggle="modal" data-target="#modalFilter">
                        <i class="feather icon-search"></i>
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

<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Filter Pelayanan Masyarakat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formFilter">
      <div class="modal-body">
            <div class="row">
                <div class="col-6 form-group">
                    <label for="">Start</label>
                    <input type="date" class="form-control" id="start" value="<?= date('Y-m-01')?>">;
                </div>
                <div class="col-6 form-group">
                    <label for="">End</label>
                    <input type="date" class="form-control" id="end" value="<?= date('Y-m-d')?>">;
                </div>
                <div class="col-12 form-group">
                    <label for="">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="all" selected>Semua</option>
                        <option value="proses">Proses</option>
                        <option value="done">Selesai</option>
                        <option value="cancel">Cancel</option>
                        <option value="expired">Expired</option>

                    </select>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Filter</button>
      </div>
      </form>
    </div>
  </div>
</div>