
<div class="col-8">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?=$header ?></h5></div>
        <div class="card-block">
            <form id="formAct">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="">Judul Berita</label>
                        <input type="text" name="judul_berita" class="form-control" required value="<?= $row['berita_title'] ?>">
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="">Isi Berita</label>
                        <textarea name="isi_berita" id="editor" class="form-control"  style="height:80px;"><?= $row['berita_desc']?></textarea>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="">Category</label>
                        <select class="js-example-basic-multiple col-sm-12" multiple="multiple" name="category[]" >
                            <?php foreach($category->result_array() as $catt){
                                $cekCat = $this->model_app->view_where('berita_category',array('bc_berita_id'=>$row['berita_id'],'bc_category'=>$catt['cat_id']));
                                if($cekCat->num_rows() > 0){
                                    echo '<option value="'.$catt['cat_id'].'" selected >'.$catt['cat_category'].'</option>';
                                }else{
                                    echo '<option value="'.$catt['cat_id'].'"  >'.$catt['cat_category'].'</option>';

                                }

                            ?>
                                
                            
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="">Tags</label>
                        <select class="js-example-tokenizer col-sm-12" multiple="multiple" name="tags[]">
                            <?php 
                                 
                                 foreach($tags->result_array() as $tag){
                                        $cekTag = $this->db->query("SELECT * FROM berita WHERE berita_tag LIKE  '%".$tag['tag_seo']."%' ")->num_rows();
                                        if($cekTag > 0 AND $row['berita_tag'] != ''){
                                          
                                        echo "<option value='".$tag['tag_seo']."' selected>".$tag['tag_name']."</option>";

                                        }else{
                                        echo "<option value='".$tag['tag_seo']."'>".$tag['tag_name']."</option>";

                                        }
                                    
                                 }
                               
                              
                            ?>
                            
                           
                            <?php ?>
                                                   
                        </select>                      
                    </div>
                    <div class="col-sm-12 mt-4  form-group">
                       
                            <div class="switch d-inline m-r-10">
                                <input type="checkbox" id="switch-1" name="publish"  <?php if($row['berita_publish'] == 'y'){echo "checked";}?>>
                                <label for="switch-1" class="cr"></label>
                            </div>
                            <label>Publish</label>
                            
                        
                        
                                                    
                    </div>
                    <?php 
                        if($row['berita_publish_on'] == NULL){
                            $date =  date('Y-m-d  H:i');
                        }else{
                            $date =  date('Y-m-d H:i',strtotime($row['berita_publish_on']));
                        }
                    ?>
                    <div class="col-sm-12 form-group" id="formPublish">
                        <label for="">Publish On</label>
                        <input type="text" name="publish_on" class="form-control datepicker" id="date-format" value="<?=$date ?>"  >
                    </div>
                 
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card ">
        <div class="card-header"><h5 class="card-title">Tambah Image Detail</h5></div>
        <div class="card-block">
            <form id="formImg">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="">Foto Detail</label>
                         
                         <input name="files[]" id="files" type="file" multiple accept="image/png,image/jpg,image/jpeg" class="form-control" />
                    </div>
                    <div class="col-md-12 form-group">
                            <div class="row" id="fileBase"></div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card">
        <div class="card-header"><h5 class="card-title">Main Image</h5></div>
        <div class="card-block">
            <form id="formMain">
                <div class="row">
                    <div class="col-12 form-group">
                        <?php 
                            if(file_exists('upload/berita/'.$image['bgal_link']) && $image['bgal_link']!=''){
                                $image = base_url('upload/berita/').$image['bgal_link'];
                            }else{
                            $image = base_url('upload/berita/').'default.jpg';
                            }
                        ?>
                        <img src="<?= $image?>" alt="<?=$row['berita_title'] ?>" class="img-fluid" id="filePath">
                    </div>
                    <div class="col-md-12 form-group">
                            <label for="">Ganti Foto Header</label>
                            <input type="file" name="file" class="form-control"  accept="image/png,image/jpg,image/jpeg" onchange="loadFile(event)" required>
                    </div>
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary btn-xs float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h5 class="card-title">Detail Image</h5></div>
        <div class="card-block">
           
            <div class="row" id="detailimg">
                
            </div>
           
        </div>
    </div>
</div>
<script>
<?php 
    if($row['berita_publish_on'] == NULL){
        echo "$('#formPublish').hide();";
    }
?>

var loadFile = function(event) {
    var output = document.getElementById('filePath');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

</script>