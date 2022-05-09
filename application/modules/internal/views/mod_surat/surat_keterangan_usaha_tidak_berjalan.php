<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<style type="text/css">
		h4{
			margin: 0px;
		}
		h6{
			margin: 0px;
		}
	</style>
    <?php 
        $users = $this->model_app->view_where('users',array('users_level'=>'lurah'))->row_array();
        $banjar = $this->model_app->view_where('banjar',array('banjar_id'=>$row['pm_banjar_id']))->row_array();
     ?>
	<table width="100%"  >
		<tr >
			<td align="right"><img src="./upload/docs/logo.png" style="height: 50px"></td>
			<td align="center">
				<h4>PEMERINTAH KOTA DENPASAR</h4>
				<h4>KECAMATAN DENPASAR SELATAN</h4>
				<h4>KELURAHAN RENON</h4>
				<i>Jl. Tukad Balian No.144, Renon, Denpasar Selatan, Kota Denpasar, Bali 80226</i>
			</td>
		</tr>
	
		<tr><td colspan="2"><hr></td></tr>
		<tr><td><br></td></tr>
	</table>
	<table width="100%">
        <tr><td colspan="4" align="center"><b style="margin:0px;"><u>SURAT KETERANGAN</u></b><br><label>Nomor : B-94 /511/ III / KD / 2021</label></td></tr>
		<tr><td><br></td></tr>
        <tr><td colspan="4">Yang bertanda tangan dibawah ini :</td></tr>
		
		<tr>
			<td width="10%"></td>
			<td >Nama</td>
			
			<td align="left">: <b><?= $users['users_name']?></b></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Jabatan</td>
		
			<td align="left">: <?= strtoupper($users['users_level'])?></td>
		</tr>
	
		<tr><td><br></td></tr>
		<tr>
			<td colspan="4">
				Dengan ini menerangkan bahwa : 
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Nama </td>
		
			<td align="left">: <b>"<?= $usaha['sku_nama_usaha']?>"</b></td>
		</tr>
	
		<tr>
			<td width="10%"></td>
			<td >Alamat Usaha</td>
			
			<td align="left">: <?= $usaha['sku_alamat_usaha']?></td>
		</tr>
		<tr><td><br></td></tr>

		<tr><td colspan="4">Berdasarkan Surat Keterangan Kepala Lingkungan Banjar <?=$banjar['banjar_name'] ?> No.46/LK/2021 tanggal 12 maret 2021 menerangkan bahwa benar <?= $usaha['sku_nama_usaha']?> <b>Sudah Tidak Berjalan Sejak tahun <?= date('Y',strtotime($rows['skub_tanggal_berhenti']))?>.</b></td></tr>
		
		<tr><td><br></td></tr>
		<tr><td><br></td></tr>

		<tr><td colspan="4">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</td></tr>
		<tr><td><br></td></tr>
		<tr><td colspan="3"></td><td>Renon, <?= fullDate(date('Y-m-d'))?></td></tr>
		<tr><td colspan="3"></td><td>an. <b style="margin:0px">LURAH RENON</b><br><?= $users['users_name'] ?></td></tr>

		<tr><td><br></td></tr>
		<tr><td><br></td></tr>
		<tr><td><br></td></tr>
		<tr><td><br></td></tr>
		<tr><td colspan="3"></td><td><b style="margin:0px"></b><br>Pangkat : LURAH <br>NIP : <?= $users['users_nip']?></td></tr>
	</table>
</body>
</html>