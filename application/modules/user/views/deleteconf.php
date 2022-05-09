<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?= $page_title ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('user/manage') ?>"><i class="fa fa-file"></i> Users</a></li>
            <li class="breadcrumb-item">Delete User > <?= $query->username ?></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= validation_errors("<p style='color: red;'>", "</p>") ?>

            <?= isset($alert) ? $alert : ""; ?>
        </div>

        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <h4>You are about to delete the <?= $query->username ?> user from database</h4>
                        <hr>
                        <a class="btn btn-danger" href="<?= base_url('user/delete/'.$update_id) ?>">Yes - Delete</a>
                        &nbsp;&nbsp; - &nbsp;&nbsp;
                        <a class="btn btn-success" href="<?= base_url('user/manage') ?>">No - Cancel</a>
                </div>
            </div>
        </div>

    </div>
</main>
