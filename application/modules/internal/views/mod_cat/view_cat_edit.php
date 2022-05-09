<?php if(file_exists('upload/berita/'.$row['cat_main_img'])){ 
         $foto = base_url('upload/berita/'.$row['cat_main_img']); 
    }else{ $foto =  base_url('upload/berita/blank.png'); }?>
<div class="col-sm-4">
    <div class="card">
     <img class="card-img-top" src="<?= $foto ?>" alt="<?= $row['cat_seo']?>">
        <div class="card-header">
            <h5 class="card-title">Kategori : <?= $row['cat_category']?></h5>

        </div>
       
    </div>
    
    
</div>
<div class="col-sm-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?= $header ?></h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/category/update') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                   <div class="col-md-6 form-group">
                       <label for="">Kategori</label>
                       <input type="text" name="cat" class="form-control" required value="<?= $row['cat_category']?>">
                   </div>
                   <div class="col-md-6 form-group">
                       <label for="">Gambar Kategori</label>
                       <input type="file" name="file" class="form-control" accept="image/*" >
                   </div>
                   <div class="col-md-12 form-group">
                       <input type="hidden" name="id" value="<?= encode($row['cat_id'])?>">
                       <button class="btn btn-primary float-right">Simpan</button>
                   </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>