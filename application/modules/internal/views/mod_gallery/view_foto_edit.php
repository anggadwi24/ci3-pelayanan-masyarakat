<div class="col-md-4">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title">Foto Gallery</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <?php 
                    $photo = $this->model_app->view_where_ordering('gallery_photo',array('photo_gal_id'=>$row['gal_id']),'photo_id','DESC');
                    if($photo->num_rows() > 0 ){
                        foreach($photo->result_array() as $fot){
                            if(file_exists('upload/berita/'.$fot['photo_link'])){
                                echo "
                                <div class='col-md-6 mt-2'>
                                    <img src='".base_url('upload/berita/'.$fot['photo_link'])."' class='img-fluid'>
                                    <span class='d-block feather icon-trash-2 text-danger text-right mt-3 delete' style='font-size:20px;' data-id='".encode($fot['photo_id'])."'></span>
                                </div>";
                            }
                           
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title">Thumbnail</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <?php   

                    if($row['gal_thumbnail'] != NULL){
                        if(file_exists('upload/berita/'.$row['gal_thumbnail'])){
                            echo "
                            <div class='col-md-6 mt-2'>
                                <img src='".base_url('upload/berita/'.$row['gal_thumbnail'])."' srcset='' class='img-fluid'>
                            
                            </div>";
                        }
                    }
                           
                     
                ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
<div class="card">
        <div class="card-header"><h5 class="card-title"><?= $header ?></h5></div>
        <div class="card-block">
            <form action="<?= base_url('internal/foto/update')?>" method="post" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="">Judul Gallery</label>
                        <input type="text" class="form-control" name="title" required value="<?= $row['gal_title'] ?>"> 
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Kategori </label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option disabled selected></option>
                            <?php  
                                $kategori = $this->model_app->view_where('category',array('cat_visible'=>'y'));
                                if($kategori->num_rows() > 0){
                                    foreach($kategori->result_array() as $cat){
                                        if($cat['cat_id'] == $row['gal_category']){
                                            echo "<option value='".$cat['cat_id']."'  selected>".$cat['cat_category']."</option>";
                                            
                                        }else{
                                            echo "<option value='".$cat['cat_id']."'>".$cat['cat_category']."</option>";

                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Deskripsi</label>
                        <textarea id="editor" name="content" rows="10"><?= $row['gal_desc'] ?></textarea>
                                
                        
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="">Thumbnail</label>
                      <input type="file" name="file" class="form-control"  accept="image/png,image/jpg,image/jpeg">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Foto</label>
                         
                        <input name="files[]" id="files" type="file" multiple accept="image/png,image/jpg,image/jpeg" class="form-control" />
                                               
                    </div>
                    <div class="col-md-12 form-group">
                            <div class="row" id="fileBase"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="hidden" name="id" value="<?= encode($row['gal_id'])?>">
                        <button type="submit" class="btn btn-primary btn-icon-text float-right"><i class="feather icon-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.delete',function(){
        var id = $(this).attr('data-id');
        swal({
        title: 'Apakah anda yakin?',
        text: 'data akan terhapus',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        buttons: [ 'Batal','Hapus']
      }) .then((willDelete) => {
        if (willDelete) {
            $.ajax({
            type:'POST',
            url:'<?= base_url('internal/foto/deletePhoto')?>',
            data:{id:id},
            dataType:'json',
            success:function(resp){
                if(resp.status == true){
                    $('.delete[data-id="'+id+'"]').closest('div').remove();
                    $('.delete[data-id="'+id+'"]').remove();
                   
                   
                }else{
                    swal({
                    title:'Warning!',
                    text:resp.msg,
                    customClass: 'swal-wide',
                    icon:'error',
                    });
                }
            }
        })
        } else {
          swal.close();
        }
    });
       
    })
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