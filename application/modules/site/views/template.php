<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title><?= $title ?></title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="<?= theme() ?>/images/favicon.ico" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/bootstrap.min.css">

    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/font-awesome.min.css">

    <!--====== nice select css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/nice-select.css">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/magnific-popup.css">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/slick.css">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/default.css">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="<?= theme() ?>/css/style.css">
    <link rel="stylesheet" href="<?= theme() ?>/js/vendor/select2/css/select2.min.css">


</head>

<body>
  
    <!--====== OFFCANVAS MENU PART START ======-->
    <div class="loader" id="loader" style="display:none;">
        <div class="container">
            <div class="mx-auto text-center ">
                <img src="<?= theme() ?>/images/logos.png" class="img-fluid" alt="">
                <span>L O A D I N G</span>
            </div>
        </div>
    </div>
    <div class="binduz-er-news-off_canvars_overlay"></div>
    <div class="binduz-er-news-offcanvas_menu">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="binduz-er-news-offcanvas_menu_wrapper">
                        <div class="binduz-er-news-canvas_close">
                            <a href="javascript:void(0)"><i class="fal fa-times"></i></a>
                        </div>
                       
                        <div id="menu" class="text-left ">
                            <ul class="binduz-er-news-offcanvas_main_menu">
                                    <?php 
                                    $parent = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>NULL),'mw_urutan','ASC');
                                    if($parent->num_rows() > 0){
                                        foreach($parent->result_array() as $par){
                                            $child = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>$par['mw_id']),'mw_urutan','ASC');
                                            if($child->num_rows() > 0){
                                                echo "<li class='binduz-er-news-menu-item-has-children'>
                                                            <a  href='#'>".$par['mw_name']." </a>
                                                            <ul class='binduz-er-news-sub-menu'>";
                                                            foreach($child->result_array() as $chi){
                                                                echo "<li><a href='".$chi['mw_link']."'>".$chi['mw_name']."</a></li>";
                                                            }
                                                echo "   </ul>
                                                    </li>";
                                            }else{
                                                echo "<li class='binduz-er-news-menu-item-has-children'>
                                                            <a  href='".$par['mw_link']."'>".$par['mw_name']." </a>
                                                        </li>";
                                            }
                                            
                                        }
                                    }
                                ?>
                               
                            </ul>
                        </div>
                        <div class="binduz-er-news-offcanvas_footer">
                            <div class="binduz-er-news-logo text-center mb-30 mt-30">
                                <a href="<?= base_url()?>">
                                    <img src="<?= theme() ?>/images/logo.png" alt="">
                                </a>
                            </div>
                            <p>Kelurahan Renon Kecamatan Denpasar Selatan</p>
                            <ul>
                                <li><i class="fas fa-phone"></i> (0361) 8956202 / 8956333</li>
                                <li><i class="fas fa-home"></i> Jl. Tukad Balian No.144, Denpasar Selatan</li>
                                <li><i class="fas fa-envelope"></i> renon@denpasarkota.go.id </li>
                                <li><i class="fas fa-envelope"></i> kelurahanrenon@gmail.com</li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== OFFCANVAS MENU PART ENDS ======-->

    <!--====== SEARCH PART START ======-->

    <div class="binduz-er-news-search-box">
        <div class="binduz-er-news-search-header">
            <div class="container mt-60">
                <div class="row">
                   
                    <div class="col-6 offset-6">
                        <div class="binduz-er-news-search-close float-end">
                            <button class="binduz-er-news-search-close-btn">Close <span></span><span></span></button>
                        </div> <!-- search close -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- search header -->
        <div class="binduz-er-news-search-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="binduz-er-news-search-form">
                            <form action="<?= base_url('site/search')?>">
                                <input type="text" placeholder="Cari berita/galery" name="key">
                                <button><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- search body -->
    </div>

    <!--====== SEARCH PART ENDS ======-->

    <!--====== BINDUZ TOP HEADER PART START ======-->

    <div class="binduz-er-top-header-area-4 bg_cover d-none d-lg-block">
        <div class=" container">
            <div class="row align-items-center">
                <div class=" col-lg-6 col-md-7">
                   
                    <div class="binduz-er-top-header-weather">
                        <ul>
                            <li><a href="#"><i class="fal fa-calendar-alt"></i> <?= haribali(date('Y-m-d'))?> <?= pancawara(date('Y-m-d'))?>,<?=tanggal(date('Y-m-d')) ?> </a></li>
                            <li id="weather"></li>
                            
                        </ul>
                    </div>
                </div>
                <div class=" col-lg-6 col-md-5">
                    <div class="binduz-er-topbar-headline float-end">
                        <?php $trending = $this->model_app->view_where_ordering_limit('berita',array('berita_visible'=>'y','berita_publish'=>'y'),'berita_views','DESC',0,5);
                        if($trending->num_rows() > 0){
                            foreach($trending->result_array() as $trend)   {
                                echo '<p><span><i class="fas fa-bolt"></i> Trending News:</span> <a href="'.base_url().$trend['berita_seo'].'">'.limitString($trend['berita_title'],30).'</a></p>';
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--====== BINDUZ TOP HEADER PART ENDS ======-->

    <!--====== BINDUZ HEADER PART START ======-->

    <header class="binduz-er-header-area">
        <div class="binduz-er-header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navigation">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-brand logo"><a href="index.html"><img src="<?= theme() ?>/images/logo.png" alt=""></a></div> <!-- logo -->
                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <ul class="navbar-nav m-auto">
                                        <?php 
                                            $parent = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>NULL),'mw_urutan','ASC');
                                            if($parent->num_rows() > 0){
                                                foreach($parent->result_array() as $par){
                                                    $child = $this->model_app->view_where_ordering('menu_website',array('mw_parent'=>$par['mw_id']),'mw_urutan','ASC');
                                                    if($child->num_rows() > 0){
                                                        echo "<li class='nav-item'>
                                                                 <a class='nav-link' href='#'>".$par['mw_name']." <i class='fa fa-angle-down'></i></a>
                                                                 <ul class='sub-menu'>";
                                                                    foreach($child->result_array() as $chi){
                                                                        echo "<li><a href='".$chi['mw_link']."'>".$chi['mw_name']."</a></li>";
                                                                    }
                                                        echo "   </ul>
                                                         </li>";
                                                    }else{
                                                        echo "<li class='nav-item'>
                                                                 <a class='nav-link' href='".$par['mw_link']."'>".$par['mw_name']." </a>
                                                             </li>";
                                                    }
                                                   
                                                }
                                            }
                                        ?>
                                      
                                    </ul>
                                </div> <!-- navbar collapse -->
                                <div class="binduz-er-navbar-btn d-flex">
                                    <div class="binduz-er-widget d-flex">
                                        <a class="binduz-er-news-search-open" href="#"><i class="far fa-search"></i></a>
                                        
                                    </div>
                                    <span class="binduz-er-toggle-btn binduz-er-news-canvas_open d-block d-lg-none">
                                        <i class="fal fa-bars"></i>
                                    </span>
                                </div>
                            </nav>
                        </div> <!-- navigation -->
                    </div>
                </div> <!-- row -->
            </div>
        </div>
    </header>

    <!--====== BINDUZ HEADER PART ENDS ======-->
    <?php 
        if( isset($breadcumb)){

        
    ?>
    <div class="binduz-er-breadcrumb-area" style="margin-bottom:0">
        <div class=" container">
            <div class="row">
                <div class=" col-lg-12">
                    <div class="binduz-er-breadcrumb-box">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                               <?= $breadcumb ?>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php }?>


    <?=$contents ?>

    <!--====== BINDUZ FOOTER PART START ======-->

    <footer class="binduz-er-footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="binduz-er-footer-widget-style-1">
                                <div class="binduz-er-footer-title">
                                    <h3 class="binduz-er-title">Categories</h3>
                                </div>
                                <div class="binduz-er-footer-menu-list">
                                    <?php $categori = $this->model_app->view_where_ordering_limit('category',array('cat_visible'=>'y'),'cat_category','ASC',0,6);?>
                                    <ul>
                                        <?php if($categori->num_rows() > 0){
                                                foreach($categori->result_array() as $cat)    {
                                                    echo "<li><a href='".base_url()."site/category/".$cat['cat_seo']."'>".$cat['cat_category']."</a></li>";
                                                }
                                            }
                                        ?>
                                            
                                        
                                    </ul>
                                    <?php $categori2 =$this->model_app->view_where_ordering_limit('category',array('cat_visible'=>'y'),'cat_category','ASC',6,6); ?>
                                    <?php if($categori2->num_rows() > 0){?>
                                        <ul>
                                            <?php foreach($categori2->result_array() as $cat2){
                                                    echo "<li><a href='".base_url()."site/category/".$cat2['cat_seo']."'>".$cat2['cat_category']."</a></li>";

                                            }?>
                                        </ul>
                                    <?php }?>
                                   
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-lg-6 col-md-6">
                            <div class="binduz-er-footer-widget-style-3">
                                <div class="binduz-er-footer-title">
                                    <h3 class="binduz-er-title">Recent Feeds</h3>
                                </div>
                                <div class="binduz-er-footer-widget-feeds">
                                    <div class="binduz-er-sidebar-latest-post-box">
                                        <?php 
                                            $recent = $this->model_app->view_where_ordering_limit('berita',array('berita_visible'=>'y','berita_publish'=>'y'),'berita_id','DESC',0,2);
                                            if($recent->num_rows() > 0){
                                                foreach($recent->result_array() as $rec){
                                                    $img = $this->model_app->view_where('berita_gallery',array('bgal_berita_id'=>$rec['berita_id'],'bgal_main_img'=>'y'))->row_array();
                                                    if(file_exists('upload/berita/'.$img['bgal_link'])){
                                                        $thumb = base_url('upload/berita/').$img['bgal_link'];
                                                    }else{
                                                        $thumb =base_url('upload/berita/default.jpg');
                                                    }
                                                    echo '<div class="binduz-er-sidebar-latest-post-item">
                                                    <div class="binduz-er-thumb">
                                                        <img src="'.$thumb.'" alt="latest" style="width:160px;height:160px;">
                                                    </div> 
                                                    <div class="binduz-er-content">
                                                        <span><i class="fal fa-calendar-alt"></i> '.tanggal($rec['berita_publish_on']).'</span>
                                                        <h4 class="binduz-er-title"><a href="'.base_url($rec['berita_seo']).'">'.limitString($rec['berita_title'],30).'</a></h4>
                                                    </div>
                                                </div>';
                                                }
                                            }
                                            
                                        ?>
                                        
   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="binduz-er-footer-widget-info">
                        <div class="binduz-er-logo">
                            <a href="#"><img src="<?= theme() ?>/images/logo.png" alt=""></a>
                        </div>
                        <div class="binduz-er-text">
                            <p>Kelurahan Renon Kecamatan Denpasar Selatan.</p>
                        </div>
                        <div class="binduz-er-social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="binduz-er-back-to-top">
            <p>BACK TO TOP <i class="fal fa-long-arrow-right"></i></p>
        </div>
    </footer>
    <div class="binduz-er-footer-copyright-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="binduz-er-copyright-text">
                        <p>Copyright By <span>Kelurahan Renon</span> - <?= date('Y')?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!--====== BINDUZ FOOTER PART ENDS ======-->

    <!--====== BINDUZ BACK TO TOP PART START ======-->

    <div class="binduz-er-back-to-top">
        <p>BACK TO TOP <i class="fal fa-long-arrow-right"></i></p>
    </div>

    <!--====== BINDUZ BACK TO TOP PART ENDS ======-->












    <!--====== jquery js ======-->
    <script src="<?= theme()?>/js/vendor/sweetalert/js/sweetalert.min.js"></script>
    <?php if($this->session->flashdata('message')){
        echo "<script>
                swal({
                    title:'Ooppss',
                    text:'".$this->session->flashdata('message')."',
                    customClass: 'swal-wide',
                    icon:'error',
                });
            </script>";
    }?>
    <?php if($this->session->flashdata('success')){
        echo "<script>
                swal({
                    title:'Success',
                    text:'".$this->session->flashdata('success')."',
                    customClass: 'swal-wide',
                    icon:'success',
                });
            </script>";
    }?>
    <script src="<?= theme() ?>/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="<?= theme() ?>/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?= theme() ?>/js/vendor/select2/js/select2.full.min.js"></script>
    <script>
        var api = '<?= encode(current_url()) ?>';
        $('body').append('<input type="hidden" id="apiKey" value="'+api+'">');


    </script>
    <?php 
        if($js != ""){
            echo '<script src="'.$js.'" type="module"></script>';
        }
    ?>

    <script src="<?= theme() ?>/js/bootstrap.min.js"></script>
    <script src="<?= theme() ?>/js/popper.min.js"></script>

    <!--====== Slick js ======-->
    <script src="<?= theme() ?>/js/slick.min.js"></script>

    <!--====== nice select js ======-->
    <script src="<?= theme() ?>/js/jquery.nice-select.min.js"></script>

    <!--====== Isotope js ======-->
    <script src="<?= theme() ?>/js/isotope.pkgd.min.js"></script>

    <!--====== Images Loaded js ======-->
    <script src="<?= theme() ?>/js/imagesloaded.pkgd.min.js"></script>

    <!--====== Magnific Popup js ======-->
    <script src="<?= theme() ?>/js/jquery.magnific-popup.min.js"></script>

    <!--====== Main js ======-->
    <script src="<?= theme() ?>/js/main.js"></script>

</body>

</html>
