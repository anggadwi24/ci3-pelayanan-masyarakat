<!DOCTYPE html>
<html lang="in">

<head>
    <title><?= $title ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Internal Kelurahan Renon, Denpasar Selatan"/>
    <meta name="keywords" content="Internal Kelurahan Renon, Denpasar Selatan">
    <meta name="author" content="Jua Kopi" />

    <!-- Favicon icon -->
    <link rel="icon" href="<?= theme() ?>/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="<?= theme() ?>/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="<?= theme() ?>/plugins/animation/css/animate.min.css">
    <!-- notification css -->
    <link rel="stylesheet" href="<?= theme() ?>/plugins/notification/css/notification.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?= theme() ?>/plugins/data-tables/css/datatables.min.css">
    <link rel="stylesheet" href="<?= theme() ?>/plugins/select2/css/select2.min.css">
    <!-- multi-select css -->
    <link rel="stylesheet" href="<?= theme() ?>/plugins/multi-select/css/multi-select.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?=theme()?>/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css">
    <!-- Bootstrap datetimepicker css -->
    <link rel="stylesheet" href="<?=theme()?>/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?= theme() ?>/css/style.css">
     <!-- select2 Js -->
  

    <script src="<?= theme() ?>/js/vendor-all.min.js"></script>
	<script src="<?= theme() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    
    <style>
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>

</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <div class="loading" style="display:none">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->

   
   
        <?= $this->load->view('main_header')?>
    
  
    
    <!-- [ chat message ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10"><?= $page ?></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('internal/dashboard')?>"><i class="feather icon-home"></i></a></li>
                                        <?= $breadcrumb?>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <?= $contents?>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="<?= theme() ?>/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="<?= theme() ?>/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="<?= theme() ?>/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="<?= theme() ?>/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="<?= theme() ?>/images/browser/ie.png" alt="">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Js -->
    

    <script src="<?= theme()?>/plugins/sweetalert/js/sweetalert.min.js"></script>
    <?php if($this->session->flashdata('message')){
        echo "<script>
                swal({
                    title:'Warning!',
                    text:'".$this->session->flashdata('message')."',
                    customClass: 'swal-wide',
                    icon:'error',
                });
            </script>";
    }?>
    <?php if($this->session->flashdata('success')){
        echo "<script>
                swal({
                    title:'Success!',
                    text:'".$this->session->flashdata('success')."',
                    customClass: 'swal-wide',
                    icon:'success',
                });
            </script>";
    }?>
    <?php if($js){
        echo "<script  type='module' src='".$js."'></script>";
    } ?>
    <script type="module" src="<?= theme() ?>/js/core.js"></script>

    <script src="<?= theme() ?>/js/pcoded.min.js"></script>
    <!-- amchart js -->
  
    <script src="<?= theme() ?>/plugins/data-tables/js/datatables.min.js"></script>
    <script src="<?= theme() ?>/js/pages/tbl-datatable-custom.js"></script>
    <script src="<?=theme()?>/plugins/select2/js/select2.full.min.js"></script>

    <!-- multi-select Js -->
    <script src="<?=theme()?>/plugins/multi-select/js/jquery.quicksearch.js"></script>
    <script src="<?=theme()?>/plugins/multi-select/js/jquery.multi-select.js"></script>

    <!-- form-select-custom Js -->
    <script src="<?=theme()?>/js/pages/form-select-custom.js"></script>
    <script src="<?= theme()?>/plugins/ckeditor/js/ckeditor.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            // Inline editor
           
            ClassicEditor
            .create( document.querySelector( '#editor' ), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            
            } )
            .catch( error => {
                console.error( error );
            } );
        });
    </script>
    <!-- notification Js -->
    <script src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>

    <script src="<?=theme()?>/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?=theme()?>/js/pages/form-picker-custom.js"></script>
    <script src="<?= theme() ?>/plugins/notification/js/bootstrap-growl.min.js"></script>

    <!-- dashboard-custom js -->
    <!-- <script src="<?= theme() ?>/js/pages/dashboard-custom.js"></script> -->

</body>

</html>
