
<section class="binduz-er-main-posts-area">
    <div class=" container">
        <form id="formAct">
            <div class="row ">
            
            <div class="col-xl-4 col-lg-4 col-md-4 col-xs-12 col-sm-12">
                <div class="card border-0 " style="background-color:#f1f1f1">
                    
                    <div class="card-body">
                    
                       <div class="row g-3">
                           <div class="col-12 ">
                                <h5 class="card-title">Data Pelayanan</h5>
                           </div>
                            <div class="col-12 ">
                                <label for="" class="form-label">Pelayanan</label>
                                <select name="pelayanan" id="pelayanan" class="form-control" required></select>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Sub Pelayanan</label>
                                <select name="sub_pelayanan" id="sub_pelayanan" class="form-control" required></select>
                            </div>
                            <div class="col-12  ">
                                <label for="" class="form-label">Banjar</label>
                                <select name="banjar" id="banjar" class="form-control" required></select>
                            </div>
                            <div class="col-12 ">
                                <label for="" class="form-label">Email </label>
                                <input type="email" class="form-control" name="email" required placeholder="Masukan email">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Foto KTP</label>
                                <input class="form-control " id="file" type="file" name="file" accept="image/*">
                            </div>
                            <div class="col-12 ">
                                <img src="<?= base_url('upload/docs/identity.jpg') ?>" alt="" srcset="" id="imgFile" class="img-fluid card-img ">
                            </div>
                        </div>
                       
                    </div>
                </div>

            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <div class="card border-0">
                    
                    <div class="card-body">
                    
                       <div class="row g-3">
                           <div class="col-12 ">
                                <h5 class="card-title">Data Diri    </h5>
                           </div>
                           <div class="col-4 form-group">
                                <label class="form-label">NIK</label>
                                <input type="number" class="form-control" name="nik" id="nik" required placeholder="Masukan NIK">
                            </div>
                            <div class="col-8 form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" required placeholder="Masukan Nama">
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="male">Laki - Laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Agama</label>
                                <select name="religion" id="religion" class="form-control" required>
                                    <option disabled selected>Pilih Agama</option>
                                    <option value="islam">Islam</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="khatolik">Khatolik</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="konghucu">Konghucu</option>


                                </select>
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="pob" required id="pob" placeholder="Masukan Tempat Lahir">
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="dob" required id="dob" placeholder="Masukan Tanggal Lahir" max="<?= date('Y-m-d',strtotime('-17 Years')) ?>" >
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Pekerjaan</label>
                                <select name="job" id="job" class="form-control"></select>
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Negara</label>
                                <select name="country" id="country" class="form-control"></select>
                            </div>
                            <div class="col-6 form-group" id="formProv"></div>
                            <div class="col-6 form-group" id="formKab" ></div>
                            <div class="col-6 form-group" id="formKec" ></div>
                            <div class="col-6 form-group" id="formKel" ></div>

                            <div class="col-12 form-group">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Masukan alamat "></textarea>
                            </div>
                            <div class="col-6 form-group my-3" id="recaptcha">
                              
                            </div>
                            <div class="col-6 form-grouup mt-5">
                                <button class="btn btn-primary  float-end">PENGAJUAN</button>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>

            
        </form>
    </div>
</section>
