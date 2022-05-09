<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="CodedThemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="<?= theme()?>/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="<?= theme()?>/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="<?= theme()?>/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?= theme()?>/css/style.css">

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                       <img src="<?= base_url('upload/docs/logo.png')?>" class="img-fluid" style="width:100px;height:100px; " alt="">
                    </div>
                  
                    <form id="formAct">
                        <div class="input-group mb-3">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email / Username" required>
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group text-left">
                            <div class="checkbox checkbox-fill d-inline">
                                <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                                <label for="checkbox-fill-a1" class="cr"> Remember me</label>
                            </div>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4">Login</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <!-- Required Js -->
    <script src="<?= theme()?>/js/vendor-all.min.js"></script><script src="<?= theme()?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= theme()?>/js/pcoded.min.js"></script>

</body>
</html>
