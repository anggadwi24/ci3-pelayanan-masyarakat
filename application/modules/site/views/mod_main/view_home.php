
    <!--====== BINDUZ TRENDING PART START ======-->
        <!--====== BINDUZ HERO PART START ======-->

    <div class="hero-slide-active" id="slideNew2112s">
       <?php 
         $data = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_views','DESC',3,0);
         if($data->num_rows() > 0){
             foreach($data->result_array() as $row){
                 if(file_exists('upload/berita/'.$row['bgal_link'])){
                     $img = base_url().'upload/berita/'.$row['bgal_link'];
                 }else{
                     $img = base_url().'upload/berita/default.jpg';
                 }
                 $category = null;
                 $cat = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$row['berita_id']));
                 if($cat->num_rows() > 0){
                     foreach($cat->result_array() as $ct){
                                
                         $category .= "<a href='".base_url('category/'.$ct['cat_seo'])."' class='mx-2'>".$ct['cat_category']."</a>";
                     }
                 }
                 $user = $this->model_app->view_where('users',array('users_id'=>$row['berita_created_by']))->row_array();
                 echo '<div class="binduz-er-hero-area d-flex align-items-center" style="max-height:1280px;max-width:1920px">
                                 <div class="binduz-er-bg-cover" style="background-image:url('.$img.')"></div>
                                 <div class="container">
                                     <div class="row">
                                         <div class="col-lg-5 col-md-7">
                                             <div class="binduz-er-hero-news-content">
                                                 <div class="binduz-er-hero-meta">
                                                     <div class="binduz-er-meta-category">
                                                         '.$category.'
                                                     
                                                     </div>
                                                     <div class="binduz-er-meta-date">
                                                         <span><i class="fal fa-calendar-alt"></i> '.tanggal($row['berita_publish_on']).'</span>
                                                     </div>
                                                 </div>
                                                 <div class="binduz-er-hero-title">
                                                     <h3 class="binduz-er-title"><a href="'.base_url($row['berita_seo']).'">'.limitString($row['berita_title'],100).'</a></h3>
                                                 </div>
                                                 <div class="binduz-er-meta-author">
                                                     <div class="binduz-er-author">
                                                         <img src="'.base_url('upload/users/').$user['users_photo'].'" style="width:40px;height:40px" alt="">
                                                         <span>By <span>'.$user['users_name'].'</span></span>
                                                     </div>
                                                     <div class="binduz-er-meta-list">
                                                         <ul>
                                                             <li><i class="fal fa-eye"></i> '.$row['berita_views'].'</li>
                                                            
                                                         </ul>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-lg-7">
                                             
                                         </div>
                                     </div>
                                 </div>
                             </div>';
             }
         }
         
       ?>
    </div>
    <div class="hero-portal-area">
    <div class="binduz-er-hero-news-portal hero-portal-active">
        <?php if($data->num_rows() > 0){
            foreach($data->result_array() as $row){
                if(file_exists('upload/berita/'.$row['bgal_link'])){
                    $img = base_url().'upload/berita/'.$row['bgal_link'];
                }else{
                    $img = base_url().'upload/berita/default.jpg';
                }
                echo '
               
                    <div class="binduz-er-news-portal-item">
                        <div class="binduz-er-thumb">
                            <a href="'.base_url($row['berita_seo']).'"><img src="'.$img.'" style="width:120px;height:120px;" alt=""></a>
                        </div>
                        <div class="binduz-er-content">
                            <div class="binduz-er-post-meta-date">
                                <span><i class="fal fa-calendar-alt"></i>'.tanggal($row['berita_publish_on']).'</span>
                            </div>
                            <h4 class="binduz-er-title"><a href="'.base_url($row['berita_seo']).'">'.limitString($row['berita_title'],50).'</a></h4>
                        </div>
                    </div>
               ';
            }
            
         }?>
        </div>
        
    </div>

    <!--====== BINDUZ HERO PART ENDS ======-->
    <section class="binduz-er-trending-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="binduz-er-trending-news-topbar d-block d-md-flex justify-content-between align-items-center">
                        <div class="binduz-er-trending-box">
                            <div class="binduz-er-title">
                                <h3 class="binduz-er-title">Trending News</h3>
                            </div>
                        </div>

                        <div class="binduz-er-news-tab-btn d-flex justify-content-md-end justify-content-start">
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="binduz-er-trending-news-list">
                                <div class="tab-content mt-50" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                        <div class="row">
                                    <?php 
                                        $tabsAll = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_views','DESC',1,0);
                                        if($tabsAll->num_rows() > 0){
                                           
                                            echo ' ';
                                            foreach($tabsAll->result_array() as $tall){
                                                if(file_exists('upload/berita/'.$tall['bgal_link'])){
                                                    $imgAll = base_url().'upload/berita/'.$tall['bgal_link'];
                                                }else{
                                                    $imgAll = base_url().'upload/berita/default.jpg';
                                                }
                                                $categoryz = '';
                                                $catz = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$tall['berita_id']));
                                                if($catz->num_rows() > 0){
                                                    foreach($catz->result_array() as $ctz){
                                                               
                                                        $categoryz .= "<a href='".base_url('category/'.$ctz['cat_seo'])."' style='margin-right:10px;' >".$ctz['cat_category']."</a>";
                                                    }
                                                }
                                                
                                                    echo '<div class="col-lg-7 col-md-6">
                                                    <div class="binduz-er-trending-box">
                                                        <div class="binduz-er-trending-news-item">
                                                            <img src="'.$imgAll.'" alt="" style="width:553px;height:450px">
                                                            <div class="binduz-er-trending-news-overlay">
                                                                <div class="binduz-er-trending-news-meta">
                                                                    <div class="binduz-er-meta-categories">
                                                                        '.$categoryz.'
                                                                    </div>
                                                                    <div class="binduz-er-meta-date">
                                                                        <span><i class="fal fa-calendar-alt"></i> '.tanggal($tall['berita_publish_on']).'</span>
                                                                    </div>
                                                                    <div class="binduz-er-trending-news-title">
                                                                        <h3 class="binduz-er-title"><a href="'.base_url($tall['berita_seo']).'">'.limitString($tall['berita_title'],30).'</a></h3>
                                                                    </div>
                                                                </div>
                                                                <div class="binduz-er-news-share">
                                                                    <a href="'.base_url($tall['berita_seo']).'"><i class="fal fa-share"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                               
                                            }
                                           
                                        }
                                        echo ' <div class="col-lg-5 col-md-6">
                                                    <div class="binduz-er-trending-news-list-item">';
                                        $tabsOther = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_views','DESC',3,1);
                                        if($tabsOther->num_rows() > 0){
                                           
                                            echo ' ';
                                            foreach($tabsOther->result_array() as $tobs){
                                                if(file_exists('upload/berita/'.$tobs['bgal_link'])){
                                                    $imgTo = base_url().'upload/berita/'.$tobs['bgal_link'];
                                                }else{
                                                    $imgTo = base_url().'upload/berita/default.jpg';
                                                }
                                                $categoryT = '';
                                                $cato = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$tobs['berita_id']));
                                                if($cato->num_rows() > 0){
                                                    foreach($cato->result_array() as $cto){
                                                               
                                                        $categoryT .= "<a href='".base_url('category/'.$cto['cat_seo'])."' style='margin-right:10px;' > ".$cto['cat_category']."</a>";
                                                    }
                                                }
                                                echo  '<div class="binduz-er-trending-news-list-box">
                                                            <div class="binduz-er-thumb">
                                                                <img src="'.$imgTo.'" alt="" style="width:116px;height:100px">
                                                            </div>
                                                            <div class="binduz-er-content">
                                                                <div class="binduz-er-meta-item">
                                                                    <div class="binduz-er-meta-categories">
                                                                        '.$categoryT.'
                                                                    </div>
                                                                    <div class="binduz-er-meta-date">
                                                                        <span><i class="fal fa-calendar-alt"></i> '.tanggal($tobs['berita_publish_on']).'</span>
                                                                    </div>
                                                                </div>
                                                                <div class="binduz-er-trending-news-list-title">
                                                                    <h4 class="binduz-er-title"><a href="'.base_url($tobs['berita_seo']).'">'.limitString($tobs['berita_title'],30).'</a></h4>
                                                                </div>
                                                            </div>
                                                        </div>';
                                            }
                                        }
                                        echo "      </div>
                                                </div>";
                                    
                                    ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="  col-lg-3 col-md-12">
                    <div class="binduz-er-sidebar-categories">
                        <div class="binduz-er-sidebar-title">
                            <h4 class="binduz-er-title">Categories</h4>
                        </div>
                        <div class="binduz-er-categories-list">
                            <?php
                                $categories = $this->db->query("SELECT cat_category,cat_main_img,cat_seo,COUNT(c.berita_id) as jumlah FROM berita_category a JOIN category b ON a.bc_category = b.cat_id JOIN berita c ON a.bc_berita_id = c.berita_id WHERE c.berita_visible ='y' AND c.berita_publish = 'y' GROUP BY bc_category ORDER BY jumlah DESC LIMIT 6"  );
                                if($categories->num_rows()> 0){
                                    foreach($categories->result_array() as $cats){
                                        
                                        echo ' <div class="binduz-er-item" style ="background-image:url('.base_url('upload/berita/').$cats['cat_main_img'].')">
                                                    <a href="'.base_url('category/').$cats['cat_seo'].'">
                                                        <span>'.ucfirst($cats['cat_category']).'</span>
                                                        <span class="binduz-er-number">'.$cats['jumlah'].'</span>
                                                    </a>
                                                </div>';
                                    }
                                }
                            
                            ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!--====== BINDUZ VIDEO POST PART START ======-->

    <section class="binduz-er-video-post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="binduz-er-video-post-topbar">
                        <div class="binduz-er-video-post-title">
                            <h3 class="binduz-er-title">Gallery</h3>
                        </div>
                    </div>
                </div>
               
            </div>
            <?php 
            
                $gallery= $this->model_app->view_where_ordering_limit('gallery',array('gal_visible'=>'y'),'gal_views','DESC',0,6);

            ?>
            <div class=" row">
                <?php 
                    if($gallery->num_rows() > 0){
                        $no = 1;
                        $count = $gallery->num_rows();
                        if($count == 1){
                            $col = "col-lg-12 col-md-12";
                        }else if($count == 2){
                            $col = "col-lg-6 col-md-6";
                        }else if($count == 3){
                            $col = "col-lg-4 col-md-4";
                        }else if($count > 3){
                            $col = "col-lg-4 col-md-6";
                        }
                       
                        
                        foreach($gallery->result_array() as $gal){
                            if($gal['gal_thumbnail'] != NULL){
                                $img = base_url().'upload/berita/'.$gal['gal_thumbnail'];
                            }else{
                                if($gal['gal_status'] == 'photo'){
                                    $photo = $this->model_app->view_where('gallery_photo',array('photo_gal_id'=>$gal['gal_id']))->row_array();
                                    $img = base_url('upload/berita/'.$photo['photo_link']);
                                }else{
                                    $img = base_url('upload/berita/video.jpg');

                                }
                               
                            }
                            $catg = $this->model_app->view_where('category',array('cat_id'=>$gal['gal_category']))->row_array();
                            if($gal['gal_status'] == 'video'){
                                
                                
                                $play = ' <div class="binduz-er-play">
                                <a class="binduz-er-video-popup" href="'.base_url('gallery/'.$gal['gal_seo']).'"><i class="fas fa-play"></i></a>
                            </div>';

                            }else if($gal['gal_status'] == 'photo'){
                                
                                $play = '';
                            }
                            echo '<div class="'.$col.' order-lg-1 order-1">
                                    <div class="binduz-er-video-post-item">
                                        <div class="binduz-er-trending-news-list-box">
                                            <div class="binduz-er-thumb">
                                                <img src="'.$img.'" alt="" style="height:200px">
                                                '.$play.'
                                            </div>
                                            <div class="binduz-er-content">
                                                <div class="binduz-er-meta-item">
                                                    <div class="binduz-er-meta-categories">
                                                        <a href="'.base_url('gallery/category'.$catg['cat_seo']).'">'.$catg['cat_category'].'</a>
                                                    </div>
                                                    <div class="binduz-er-meta-date">
                                                        <span><i class="fal fa-calendar-alt"></i> '.tanggal($gal['gal_date']).'</span>
                                                    </div>
                                                </div>
                                                <div class="binduz-er-trending-news-list-title">
                                                    <h4 class="binduz-er-title"><a href="'.base_url('gallery/'.$gal['gal_seo']).'">'.limitString($gal['gal_title'],50).'</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                ?>
                
                </div>
               
                
            </div>
        </div>
    </section>

    <!--====== BINDUZ VIDEO POST PART ENDS ======-->

 

    <!--====== BINDUZ MAIN POSTS PART START ======-->

    <section class="binduz-er-main-posts-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="binduz-er-video-post-topbar">
                        <div class="binduz-er-video-post-title">
                            <h3 class="binduz-er-title">Berita terbaru</h3>
                        </div>
                    </div>
                    <div class="row">
                    <?php 
                    $main = $this->model_app->join_where_order_limit('berita','berita_gallery','berita_id','bgal_berita_id',array('berita_visible'=>'y','berita_publish'=>'y','bgal_main_img'=>'y'),'berita_publish_on','DESC',12,0);
                    if($main->num_rows() > 0){
                        foreach($main->result_array() as $mn){
                            if(file_exists('upload/berita/'.$mn['bgal_link'])){
                                $mainImg = base_url().'upload/berita/'.$mn['bgal_link'];
                            }else{
                                $mainImg = base_url().'upload/berita/default.jpg';
                            }
                            $mainCat = null;
                            $catM = $this->model_app->join_where('berita_category','category','bc_category','cat_id',array('bc_berita_id'=>$mn['berita_id']));
                            if($catM->num_rows() > 0){
                                foreach($catM->result_array() as $ctM){
                                            
                                    $mainCat .= "<a href='".base_url('category/'.$ctM['cat_seo'])."' style='margin-right:10px;'>".$ctM['cat_category']."</a>";
                                }
                            }
                            echo '<div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="binduz-er-main-posts-item">
                                        <div class="binduz-er-trending-news-list-box">
                                            <div class="binduz-er-thumb">
                                                <img src="'.$mainImg.'" alt="" style="height:400px;">
                                            </div>
                                            <div class="binduz-er-content">
                                                <div class="binduz-er-meta-item">
                                                    <div class="binduz-er-meta-categories">
                                                      '.$mainCat.'
                                                    </div>
                                                    <div class="binduz-er-meta-date">
                                                        <span><i class="fal fa-calendar-alt"></i> '.tanggal($mn['berita_publish_on']).'</span>
                                                    </div>
                                                </div>
                                                <div class="binduz-er-trending-news-list-title">
                                                    <h4 class="binduz-er-title"><a href="#">'.limitString($mn['berita_title'],50).'</a></h4>
                                                    <p>'.limitString($mn['berita_desc'],80).'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                 ?>
                        
                    </div>
                  
                </div>
            </diV>
        </div>
    </section>

    <!--====== BINDUZ MAIN POSTS PART ENDS ======-->

   
    <!--====== BINDUZ TRENDING PART ENDS ======-->