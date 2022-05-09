<?php 
    $user =$this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
?>

<div class="col-8">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?= $header?></h5></div>
        <div class="card-block">
            <div class="row">
                <div class="col-12 form-group">
                    <h6>Link : <a href="<?= base_url($row['berita_seo'])?>"><?= base_url().$row['berita_seo'] ?></a></h6>
                </div>
                <div class="col-12 form-group">
                    <label for="">Judul Berita</label>
                    <h5><?= $row['berita_title'] ?></h5>
                </div>
                <div class="col-12 form-group">
                    <label for="">Deskripsi Berita</label>
                    <h5><?= $row['berita_desc']?></h5>
                </div>
                <div class="col-12 mt-0 mb-3">
                    <?php 
                        if(file_exists('upload/berita/'.$image['bgal_link']) && $image['bgal_link']!=''){
                            $image = base_url('upload/berita/').$image['bgal_link'];
                        }else{
                           $image = base_url('upload/berita/').'default.jpg';
                        }
                    ?>
                    <img src="<?= $image?>" alt="<?=$row['berita_title'] ?>" class="img-fluid">
                </div>
                <div class="col-4 form-group">
                    <label for="">Views</label>
                    <h5><?= $row['berita_views']?> Views</h5>
                </div>
                
                <div class="col-4 form-group">
                    <label for="">Categori</label>
                    <h5>
                        <?php 
                            if($category->num_rows() > 0){
                                foreach($category->result_array() as $catt){
                                    echo "<span class='badge badge-pill badge-primary mx-1'>".$catt['cat_category']."</span>";
                                }
                            }else{
                                echo "<i>Tidak ada category</i>";
                            }
                        ?>
                    </h5>
                </div>
                <div class="col-4 form-group">
                    <label for="">Tags</label>
                    <h5><?php 
                        $tag = explode(',',$row['berita_tag']);
                        $count = count($tag);
                       
                        for($a=0;$a<$count;$a++){
                            
                            echo "<span class='badge badge-pill badge-primary mx-1'>".$tag[$a]."</span>";
                        }
                    ?></h5>
                </div>
                <div class="col-6 form-group">
                    <label for="">Created By</label>
                    <h5><?= $user['users_name']?></h5>
                </div>
                <div class="col-6 form-group text-right">
                    <label for="">Created On</label>
                    <h5 class='text-right'><?= date('d/m/Y H:i',strtotime($row['berita_created_on']))?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card">
        <div class="card-header"><h5 class="card-title">Detail Image</h5></div>
        <div class="card-block">
            <div class="row">
                <?php 
                    if($detail->num_rows() > 0){
                        foreach($detail->result_array() as $det){
                            if(file_exists('upload/berita/'.$det['bgal_link']) && $det['bgal_link']!=''){
                                echo "<div class='col-12 mb-2'>
                                        <img class='img-fluid' src='".base_url('upload/berita/').$det['bgal_link']."'>
                                      </div>";
                            }   
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>