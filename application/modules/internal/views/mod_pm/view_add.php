<div class="col-sm-12">
        <form id="formAdd">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header"><h5 style="font-size:15px;"><?=$header?></h5></div>
                    <div class="card-block">
                   
                        <div class="row">
                            <div class="col-sm-12 form-group">
                               
                                <label for="example-text-input" class="col-form-label">No Pengajuan</label>
                                <input class="form-control" type="text" name="no_pengajuan" id="no_pengajuan" placeholder="No Pengajuan" required value="<?= generatePelayananNo()?>">
                            
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="">Pelayanan</label>
                                <select name="pelayanan" id="pelayanan" class="form-control"></select>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="">Sub Pelayanan</label>
                                <select name="sub_pelayanan" id="sub_pelayanan" class="form-control"></select>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="">Banjar</label>
                                <select name="banjar" id="banjar" class="form-control"></select>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="">Email Pemohon</label>
                                <input type="email" id="email" class="form-control"  required name="email">
                            </div>
                            <div class="col-12 form-group">
                                <label for="">Foto KTP</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file" required="" accept="image/*">
                                    <label class="custom-file-label" for="validatedCustomFile" id="labelFile">Choose file...</label>
                                    
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <img src="<?= base_url('upload/docs/identity.jpg') ?>" alt="" srcset="" id="imgFile" class="img-fluid card-img">
                            </div>
                           
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-sm-8" >
                <div class="card">
                    <div class="card-header"><h5>Data Pemohon</h5></div>
                    <div class="card-block" >
                       
                        <div class="row">
                            <div class="col-5 form-group">
                                <label for="">NIK</label>
                                <input type="number" class="form-control" name="nik" id="nik" required>
                            </div>
                            <div class="col-7 form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" required>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="male">Laki - Laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Agama</label>
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
                                <label for="">Tempat Lahir</label>
                                <input type="text" class="form-control" name="pob" required id="pob">
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="dob" required id="dob">
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Pekerjaan</label>
                                <select name="job" id="job" class="form-control"></select>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Negara</label>
                                <select name="country" id="country" class="form-control"></select>
                            </div>
                            <div class="col-6 form-group" id="formProv"></div>
                            <div class="col-6 form-group" id="formKab" ></div>
                            <div class="col-6 form-group" id="formKec" ></div>
                            <div class="col-6 form-group" id="formKel" ></div>

                            <div class="col-12 form-group">
                                <label for="">Alamat</label>
                                <textarea name="address" id="address" class="form-control" ></textarea>
                            </div>
                            
                        </div>
                       
                    </div>
                </div>
            </div>
            
           
            <div class="col-sm-12 mt-2">
                <button class="btn btn-primary float-right" id="btnPengajuan" >Pengajuan</button>
            </div>
            </form>
        </div>

   
</div>
    
