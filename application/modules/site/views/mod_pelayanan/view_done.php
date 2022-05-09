<section class="binduz-er-main-posts-area">
    <div class=" container">
        <div class="row g-5">
            <div class="col-12 mt-3  text-center">
                <img src="<?= base_url('upload/docs/done.gif') ?>" class="img-fluid" alt="">
            </div>
            <div class="col-12  text-center">
                <h5>No Pelayanan : #<?= $row['pm_no']?></h5>
                <h5>Pelayanan : <?= $pel['pelayanan_name']?> - <?= $sub['subpel_name']?></h5>
                <h5>Pemohon : <?= $temp['temp_fullname'] ?></h5>
            </div>
            <div class="col-12 text-center">
                <p>Catatan : Catat No Pelayanan diatas dan Email pada saat pengajuan pelayanan untuk melakukan pengecekan, apabila pelayanan sudah diterima, maka surat/dokumen akan terkirim ke email anda</p>
               <p>Terima kasih.</p>

            </div>
            <div class="col-12 text-center">
                <a href="<?= base_url('')?>" class="btn btn-primary ">BACK TO HOME</a>
            </div>
        </div>
    </div>
</section>