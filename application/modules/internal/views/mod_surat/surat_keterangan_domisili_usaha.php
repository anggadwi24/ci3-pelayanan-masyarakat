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
    <tr><td colspan="4" align="center"><b style="margin:0px;"><u>SURAT KETERANGAN DOMISILI USAHA</u></b><br><label>Nomor : B- 181 / 510 / VI / KD / 2021</label></td></tr>
		<tr><td><br></td></tr>
		<tr><td colspan="4">Yang bertanda tangan dibawah ini Kepala kelurahan Renon Kecamatan Denpasar Selatan Kota Denpasar  dengan ini menerangkan bahwa :</td></tr>
		<tr><td><br></td></tr>
		<tr>
			<td width="10%"></td>
			<td >Nama</td>
			
			<td align="left">: <b><?= $row['temp_fullname']?></b></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >NIK</td>
			
			<td align="left">: <?= $row['temp_nik']?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Tempat, Tanggal Lahir</td>
			
			<td align="left">: <?= $row['temp_pob']?>, <?= date('d-m-Y',strtotime($row['temp_dob']))?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Jenis Kelamin</td>
		
			<td align="left">: <?= genderIndo($row['temp_gender'])?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Agama</td>
			
			<td align="left">: <?= $row['temp_religion']?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Pekerjaan</td>
			
			<td align="left">: <?= $job['jp_name']?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Alamat</td>
			
			<td align="left">: <?= $row['temp_address']?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Keperluan</td>
			
			<td align="left">: <?= $rows['skdu_keperluan']?></td>
		</tr>
		<tr><td><br></td></tr>
		<tr>
			<td colspan="4">
				Benar saat ini nama tersebut di atas mempunyai usaha sebagaimana di bawah ini:
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Nama Usaha</td>
			
			<td align="left">: <b>"<?= $usaha['sku_nama_usaha']?>"</b></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Jenis Usaha</td>
			
			<td align="left">: <?= $usaha['sku_jenis_usaha']?></td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td >Alamat Usaha</td>
		
			<td align="left">: <?= $usaha['sku_alamat_usaha']?></td>
		</tr>
		<?php $lama = date('Y') - date('Y',strtotime($usaha['sku_tanggal_berdiri']));?>
		<tr>
			<td width="10%"></td>
			<td >Lama Usaha</td>
			
			<td align="left">: <?= $lama ?> (<?= terbilang($lama)?> ) Tahun, pada tanggal <?= date('d/m/Y',strtotime($usaha['sku_tanggal_berdiri']))?></td>
		</tr>
		<?php $users = $this->model_app->view_where('users',array('users_level'=>'lurah'))->row_array() ?>
		
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