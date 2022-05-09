<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?= $page_title ?></h1>
            <p><?= $headline ?></p>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('user/manage') ?>"><i class="fa fa-file"></i> Users</a></li>
            <li class="breadcrumb-item"><?= $headline ?></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= validation_errors("<p style='color: red;'>", "</p>") ?>

            <?= isset($alert) ? $alert : ""; ?>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <div class="tile-body">
                    <?php $form_location = base_url('user/create/' . $update_id); ?>
                    <form class="form-horizontal" method="post" action="<?= $form_location ?>">
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="default" <?= active_status($role, "default", " default ") ?>>Default</option>
                                <option value="member" <?= active_status($role, "member", " selected ") ?>>Member</option>
                                <option value="admin" <?= active_status($role, "admin", " selected ") ?>>Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">User Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" <?= active_status($status, "active", " selected ") ?>>Active</option>
                                <option value="inactive" <?= active_status($status, "inactive", " selected ") ?>>Inactive</option>
                                <option value="blocked" <?= active_status($status, "blocked", " selected ") ?>>Blocked</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <?php if (is_numeric($this->uri->segment(3))): ?>
                                <input class="form-control disabled" type="text" value="<?= $username ?>" readonly="">
                            <?php else: ?>
                                <input class="form-control" type="text" name="username" value="<?= $username ?>" required="">
                            <?php endif; ?>

                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input class="form-control" type="text" name="first_name" value="<?= $first_name ?>" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input class="form-control" type="text" name="last_name" value="<?= $last_name ?>" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" value="<?= $email ?>" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input class="form-control" type="password" name="password">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Repeat Password</label>
                            <input class="form-control" type="password" name="repeat_password">
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit" name="submit" value="Submit">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Submit
                            </button>
                            &nbsp;&nbsp;&nbsp;
                            <a href="<?= base_url('user/manage') ?>" class="btn btn-secondary" type="button">
                                <i class="fa fa-fw fa-lg fa-remove"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</main>
