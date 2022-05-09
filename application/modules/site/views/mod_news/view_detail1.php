
<section class="binduz-er-author-item-area pb-20">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-9" >
                    <?php
                         $author = $this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
                    
                         
                         $category = null;
                         $cat = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']));
                        if($cat->num_rows() > 0){
                            foreach($cat->result_array() as $ct){
                                    
                                $category .= "<a href='".base_url('category/'.$ct['cat_seo'])."' style='margin-right:10px;'>".$ct['cat_category']."</a>";
                            }
                        }
                         $gallery = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$row['berita_id'],'bgal_main_img'=>'n'));
                         $content = null;
                         if($gallery->num_rows()  > 0 ){
                             $content .= '<div class="row">';
                             foreach($gallery->result_array() as $gal){
                                $content .= '<div class=" col-lg-4 col-md-6">
                                <div class="binduz-er-blog-details-thumb mt-25">
                                    <img src="'.base_url('upload/berita/'.$gal['bgal_link']).'" alt="'.$row['berita_title'].'">
                                </div>
                            </div>';
                             }
                             $content .= "</div>";
                         }
                         $header = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$row['berita_id'],'bgal_main_img'));
                         if($header->num_rows()> 0){
                            $hed = $header->row_array();
                            $mainImg = '<div class="binduz-er-thumb">
                            <img src="'.base_url('upload/berita/'.$hed['bgal_link']).'" alt="">
                            </div>';
                         }else{ 
                             $mainImg = '';
                         }
                        echo '<div class="binduz-er-author-item mb-40">
                         '.$mainImg.'
                        <div class="binduz-er-content">
                            <div class="binduz-er-meta-item">
                                <div class="binduz-er-meta-categories">
                                  '.$category.'
                                </div>
                               
                            </div>
                            <h3 class="binduz-er-title">'.$row['berita_title'].'</h3>
                            <div class="binduz-er-meta-author">
                                <div class="binduz-er-author">
                                    <img src="'.base_url('upload/users/'.$author['users_photo']).'" style="width:40px;height:40px;" alt="">
                                    <span>By <span>'.$author['users_name'].'</span></span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="binduz-er-blog-details-box">
                            <div class="binduz-er-text">
                                '.$row['berita_desc'].'
                            </div>
                           '.$content.'
                           
                        </div>
                    </div>';
                    ?>
                    
                </div>
                <div class=" col-lg-3">
                    <div class="binduz-er-populer-news-sidebar">
                       
                        <?php $lurah = $this->model_app->view_where('users',array('users_level'=>'lurah'))->row_array();?>
                       

                        <div class="binduz-er-archived-sidebar-about">
                            <div class="binduz-er-user">
                                <img src="<?= base_url('upload/users/'.$lurah['users_photo'])?>" alt="">
                                

                            </div>
                            <span>Lurah</span>
                            <h4 class="binduz-er-title"><?= $lurah['users_name'] ?></h4>
                           
                        </div>
                        <div class="binduz-er-populer-news-sidebar-post pt-60">
                            <div class="binduz-er-popular-news-title">
                                <ul class="nav nav-pills mb-3" id="pills-tab-2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Most Popular</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Most Recent</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent-2">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="binduz-er-sidebar-latest-post-box" id="mostPopuler">
                                        <div class="binduz-er-sidebar-latest-post-item">
                                            <div class="binduz-er-thumb">
                                                <img src="<?= theme() ?>/images/latest-post-1.jpg" alt="latest">
                                            </div>
                                            <div class="binduz-er-content">
                                                <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                                <h4 class="binduz-er-title"><a href="#">Why creating inclusive classrooms matters</a></h4>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="binduz-er-sidebar-latest-post-box" id="mostRecent">
                                        <div class="binduz-er-sidebar-latest-post-item">
                                            <div class="binduz-er-thumb">
                                                <img src="<?= theme() ?>/images/latest-post-1.jpg" alt="latest">
                                            </div>
                                            <div class="binduz-er-content">
                                                <span><i class="fal fa-calendar-alt"></i> 24th February 2020</span>
                                                <h4 class="binduz-er-title"><a href="#">Why creating inclusive classrooms matters</a></h4>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="binduz-er-populer-news-social binduz-er-author-page-social mt-40">
                            <div class="binduz-er-popular-news-title">
                                <h3 class="binduz-er-title">Video Populer</h3>
                            </div>
                            <div class="binduz-er-video-post binduz-er-recently-viewed-item" id="video">
                            </div>
                        </div>  
                         <div class="binduz-er-populer-news-social binduz-er-author-page-social mt-40">
                            <div class="binduz-er-popular-news-title">
                                <h3 class="binduz-er-title">Foto Populer</h3>
                            </div>
                            <div class="binduz-er-video-post binduz-er-recently-viewed-item" id="photo">
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </section>