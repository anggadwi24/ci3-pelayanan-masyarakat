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
            <form action="<?= base_url('internal/foto/store')?>" method="post" enctype="multipart/form-data" >
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
                    <div class="col-md-12 form-group">
                        <label for="">Foto</label>
                         
                        <input name="files[]" id="files" type="file" multiple accept="image/png,image/jpg,image/jpeg" class="form-control" required/>
                                               
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
   $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
      
    $("#files").on("change", function(e) {
        $('#fileBase').html('');
        
        var files = e.target.files,
        filesLength = files.length;
        
      for (var i = 0; i < filesLength; i++) {

        var f = files[i]
        
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          
          var html = '<div class="col-md-2"><img src="'+e.target.result+'" class="img-fluid" title="'+f.name+'" alt="'+f.name+'"></img>';
         
        
            
          
          $("#fileBase").append(html);
          
        });
        fileReader.readAsDataURL(f);
       
      }
     
     
      
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>
