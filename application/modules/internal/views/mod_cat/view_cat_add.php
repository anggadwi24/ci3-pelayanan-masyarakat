<div class="col-sm-12">
<div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $header ?></h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/category/store') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                   <div class="col-md-6 form-group">
                       <label for="">Kategori</label>
                       <input type="text" name="cat" class="form-control" required>
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="">Gambar Kategori</label>
                       <input type="file" name="file" class="form-control" accept="image/*" required>
                   </div>
                   <div class="col-md-12 form-group">
                       <button class="btn btn-primary float-right">Simpan</button>
                   </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>