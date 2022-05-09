<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $header ?></h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/modul/update') ?>" method="post" >
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="modul_name">Modul</label>
                        <input type="text" class="form-control" id="modul_name" name="modul_name" placeholder="Modul" required value="<?= $row['modul_name']?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="modul_icon">Icon</label>
                        <input type="text" class="form-control" id="modul_icon" name="modul_icon" placeholder="Icon" required value="<?= $row['modul_icon']?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="modul_order">Urutan</label>
                        <input type="number" class="form-control" id="modul_order" name="modul_order" placeholder="Urutan" required value="<?= $row['modul_order']?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="modul_url">URL</label>
                        <input type="text" class="form-control" id="modul_url" name="modul_url" placeholder="URL" value="<?= $row['modul_url']?>">
                        <small class="text-danger">* Isi jika tidak memiliki subdomain yang tampil</small>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="hidden" value="<?= encode($row['modul_id'])?>" name="id">
                        <button class="btn btn-primary float-right mt-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>