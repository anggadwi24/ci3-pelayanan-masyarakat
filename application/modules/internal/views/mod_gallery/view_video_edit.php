<div class="col-sm-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Upload Video</h5>
        </div>
        <div class="card-block">
            <form action="<?= base_url('internal/video/storeVideo') ?>" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="galid" value="<?= encode($row['gal_id'])?>">

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Embed</label>
                        <select name="embed" id="embed" class="form-control" required>
                            <option value="n">Tidak</option>
                            <option value="y">Ya</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 form-group" id="formFile">
                        <label for="">Video</label>
                         
                        <input name="files" id="files" type="file"  accept="video/mp4,video/avi,video/x-matroska" class="form-control" required/>
                                               
                    </div>
                    <div class="col-md-12 form-group" id="formLink">
                        <label for="">Link Embed</label>
                        <input type="text" name="link" value="" class="form-control" id="embedUrl" placeholder="https://www.youtu.be/yjsf4Z5I5CQ">
                    </div>
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary btn-sm float-right">Simpan</button>
                    </div>
                </div>
            </form>
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

<div class="col-sm-8">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?= $header ?></h5></div>
        <div class="card-block">
            <form action="<?= base_url('internal/video/update')?>" method="post" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="">Judul Gallery</label>
                        <input type="text" class="form-control" name="title" required value="<?= $row['gal_title']?>"> 
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
                        <textarea id="editor" name="content" rows="10"><?= $row['gal_desc']?></textarea>
                                
                        
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="">Thumbnail</label>
                      <input type="file" name="file" class="form-control"  accept="image/png,image/jpg,image/jpeg">
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
<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h5 class="card-title">Video</h5></div>
        <div class="card-block">
            <div class="row">
            <?php 
                    $video = $this->model_app->view_where_ordering('gallery_video',array('vid_gal_id'=>$row['gal_id']),'vid_id','DESC');
                    if($video->num_rows() > 0 ){
                        foreach($video->result_array() as $vid){
                            if($vid['vid_embed'] == 'n'){
                                if(file_exists('upload/berita/'.$vid['vid_link'])){
                                    echo "
                                    <div class='col-md-6 mt-2'>
                                    <div class='embed-responsive embed-responsive-21by9'>
                                    <video  controls>
                                        <source src='".base_url('upload/berita/'.$vid['vid_link'])."' type='video/mp4'>
                                        
                                   
                                    </video>
                                    </div>
                                        <span class='d-block feather icon-trash-2 text-danger text-right mt-3 delete' style='font-size:20px;' data-id='".encode($vid['vid_id'])."'></span>
                                    </div>";
                                }
                            }else{
                                echo '<div class="col-md-6">
                                       
                                        <div class="embed-responsive embed-responsive-21by9">
                                           '.$vid['vid_embeded'].'
                                        </div>
                                        <span class="d-block feather icon-trash-2 text-danger text-right mt-3 delete"  style="font-size:20px;" data-id="'.encode($vid['vid_id']).'"></span>

                                      </div>';
                            }
                            
                           
                        }
                    }
                ?>
            </div>
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
            url:'<?= base_url('internal/video/deleteVideo')?>',
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
