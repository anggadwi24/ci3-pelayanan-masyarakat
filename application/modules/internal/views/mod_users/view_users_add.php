                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?= $header?></h5>
                                        </div>
                                        <div class="card-block">
                                            <form id="formAdd">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NIP</label>
                                                            <input type="number" class="form-control" name="nip" placeholder="NIP" required>
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="name" placeholder="Name.." required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Phone</label>
                                                            <input type="number" class="form-control" name="phone" placeholder="6287888888" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Level</label>
                                                            <select class="form-control" name="level" id="level">>
                                                                <option disabled selected>Select level...</option>
                                                                <option value="pegawai">Pegawai</option>
                                                                <option value="kaling">Kepala Lingkungan</option>
                                                                <option value="lurah">Lurah</option>
                                                                <option value="admin">Admin</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="formStatus" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">>
                                                                <option disabled selected>Select status...</option>
                                                                <option value="kontrak">Kontrak</option>
                                                                <option value="PNS">PNS</option>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="formBanjar" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Banjar</label>
                                                            <select class="form-control" name="banjar" >>
                                                                <option disabled selected>Select banjar...</option>
                                                                <?php 
                                                                    $banjar = $this->model_app->view_where('banjar',array('banjar_kaling'=>NULL));
                                                                    if($banjar->num_rows() > 0){
                                                                        foreach($banjar->result_array() as $bjr){
                                                                            echo "<option value='".encode($bjr['banjar_id'])."'>".$bjr['banjar_name']."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="formJabatan" style="display:none">
                                                        <div class="form-group">
                                                            <label class="form-label">Jabatan</label>
                                                            <select class="form-control" name="jabatan" id="jabatan">
                                                                <option disabled selected>Select jabatan...</option>
                                                                <?php 
                                                                    $jabatan = $this->model_app->view_order('jabatan','jabatan_name','DESC');
                                                                    if($jabatan->num_rows() > 0){
                                                                        foreach($jabatan->result_array() as $jbt){
                                                                            if($jbt['jabatan_limit'] > $jbt['jabatan_used']){
                                                                                echo "<option value='".encode($jbt['jabatan_id'])."'>".$jbt['jabatan_name']."</option>";
                                                                            }
                                                                           
                                                                        }
                                                                    }
                                                                ?>
                                                               

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Password</label>
                                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Photo</label>
                                                            <div>
                                                                <input type="file" class="validation-file" name="file" accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>