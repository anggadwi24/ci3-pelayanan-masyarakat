<style>
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}

</style>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?= $header ?></h5></div>
        <div class="card-block">
            <form action="<?= base_url('internal/video/store')?>" method="post" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="">Judul Gallery</label>
                        <input type="text" class="form-control" name="title" required> 
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Kategori </label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option disabled selected></option>
                            <?php  
                                $kategori = $this->model_app->view_where('category',array('cat_visible'=>'y'));
                                if($kategori->num_rows() > 0){
                                    foreach($kategori->result_array() as $cat){
                                        echo "<option value='".$cat['cat_id']."'>".$cat['cat_category']."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Deskripsi</label>
                        <textarea id="editor" name="content" rows="10"></textarea>
                                
                        
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="">Thumbnail</label>
                      <input type="file" name="file" class="form-control" required accept="image/png,image/jpg,image/jpeg">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Embed</label>
                        <select name="embed" id="embed" class="form-control" required>
                            <option value="n">Tidak</option>
                            <option value="y">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group" id="formFile">
                        <label for="">Video</label>
                         
                        <input name="files" id="files" type="file"  accept="video/mp4,video/avi,video/x-matroska" class="form-control" required/>
                                               
                    </div>
                    <div class="col-md-6 form-group" id="formLink">
                        <label for="">Link Embed</label>
                        <input type="text" name="link" value="" class="form-control" id="embedUrl" placeholder="https://www.youtu.be/yjsf4Z5I5CQ">
                    </div>
                    <div class="col-md-12 form-group">
                            <div class="row" id="fileBase"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary btn-icon-text float-right"><i class="feather icon-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#formLink').hide();
    $(document).on('change','#embed',function(){
        if($(this).val()  == 'y'){
            $('#formLink').show();
            $('#embedUrl').prop('required',true);
            $('#formFile').hide();
            $('#files').prop('required',false);
        }else if($(this).val() == 'n'){
            $('#formLink').hide();
            $('#embedUrl').prop('required',false);
            $('#formFile').show();
            $('#files').prop('required',true);
        }
    })
  
</script>
