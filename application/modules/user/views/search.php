<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?= $page_title ?></h1>
            <p><?= $headline ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">
                    <i class="fa fa-home fa-lg"></i></a>
            </li>
            <li class="breadcrumb-item"><?= $headline ?></li>
        </ul>
    </div>
    <div class="row">
        <?php if (isset($alert)): ?>
            <div class="col-md-12">
                <?= $alert; ?>
            </div>
        <?php endif; ?>
       
        
        <div class="clearix"></div>
        
        <div class="col-md-12">
          <div class="tile">
              <h3 class="tile-title">Your Search: <small><?= $search_query ?></small></h3>
            <div class="tile-body">
                <form class="row" method="get" action="<?= base_url('user/search') ?>">
                <div class="form-group col-md-8">
                  <label class="control-label">The query will search in: username/email/first and last name</label>
                  <input class="form-control" type="text" name="query"  placeholder="Search for">
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-fw fa-lg fa-search"></i>Submit
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        <div class="clearix"></div>

        <div class="col-md-12">
            <div class="tile">
                <p>
                    <a class="btn btn-default" href="<?= base_url('user/manage') ?>">
                        <i class="fa fa-backward"></i> Back to Users
                    </a>
                </p>
                <div class="clearix"></div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nr = 1;
                            foreach ($query as $row):
                                ?>
                                <tr>
                                    <td><?= $nr ?></td>
                                    <td><?= $row->username ?></td>
                                    <td><a href="mailto:<?= $row->email ?>"><?= $row->email ?></a></td>
                                    <td>
                                        <a class="btn btn-info" href="<?= base_url('user/create/' . $row->id) ?>">
                                            <i class="fa fa-edit"></i>
                                        </a> &nbsp;
                                        <a class="btn btn-danger" href="<?= base_url('user/deleteconf/' . $row->id) ?>">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $nr++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>



                </div>
            </div>

        </div>





    </div>
</main>