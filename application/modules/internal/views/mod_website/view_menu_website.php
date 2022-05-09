<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5><?= $header ?></h5>
        </div>
        <div class="card-block">
           
            <div class="row">
            <?php $add = __ceksesskonten('internal/website/menuAdd');
                    if($add){?>
                <div class="col-lg-12 my-2">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                       Tambah Menu
                    </button>


                </div>
                <?php }?>
                <div class="col-lg-6 my-2">
                    <div class="cf nestable">
                         <div class="dd" id="nestable-menu">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 my-2" id="dataMenu">
                    
                </div>
            
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAdd">
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="">Menu Parent</label>
                <select name="parent"  class="form-control parent"></select>
            </div>
            <div class="col-md-6 form-group">
                <label for="">Nama Menu</label>
                <input type="text" class="form-control" name="menu" required>
            </div>
            <div class="col-md-12 form-group">
                <label for="">Link Menu</label>
                <input type="text" class="form-control" name="link" >
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEdit">
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="">Menu Parent</label>
                <select name="parent" id="parents"  class="form-control parent"></select>
            </div>
            <div class="col-md-6 form-group">
                <label for="">Nama Menu</label>
                <input type="text" class="form-control" name="menu" id="menu" required>
            </div>
            <div class="col-md-12 form-group">
                <label for="">Link Menu</label>
                <input type="text" class="form-control" name="link" id="link" >
            </div>
            <input type="hidden" id="id" name="id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>