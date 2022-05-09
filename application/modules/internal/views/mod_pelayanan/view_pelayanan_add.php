<div class="col-sm-12">
<div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $header ?></h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/jabatan/store') ?>" method="post">
                <div class="row">
                   <div class="col-md-6 form-group">
                       <label for="">Jabatan Name</label>
                       <input type="text" name="name" class="form-control" required>
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="">Jabatan Limit</label>
                       <input type="number" name="limit" class="form-control" required>
                   </div>
                   <div class="col-md-12 form-group">
                       <button class="btn btn-primary float-right">Simpan</button>
                   </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>