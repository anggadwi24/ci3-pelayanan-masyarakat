<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); {
    function theme(){
        return base_url('template/public');
    }
    function replace($arr,$elem){
        return str_replace($arr,'',$elem);
    }
    function seo($s) {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
        $s = strtolower(str_replace($c, '_', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
        return $s;
    }
    function weather($city){
        $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=bc35562cfc564b8d466250e7dd73aa56&units=metric';

		$json = file_get_contents($url);
		$json_data = json_decode($json, true);
		
        $temp =  round($json_data['main']['temp'],0);
        $weather = $json_data['weather'][0]['main'];
        if($weather == 'Clouds'){
            $icon = '<i class="fal fa-cloud"></i>';
           
        }else if($weather == 'Rain'){
            $icon = '<i class="fal fa-cloud-rain"></i>';
            
        }else if($weather == 'Clear'){
            $icon = '<i class="fal fa-cloud-sun"></i>';
        }else {
            $icon = '<i class="fal fa-cloud-moon"></i>';

        }
        return $icon.' '.$city.' '.$temp.'&deg; C';
    }
    function __checkConnect($patokan,$api){
        if($patokan == $api){
            return true;
        }else{
            return false;
        }
    }
    function keys(){
        return "KELURAHANRENON2022SKRIPSIBARU109231283##";
    }
    function encode($post){
        $key =  "KELURAHANRENON2022SKRIPSIBARU109231283##";
        $ci = & get_instance();
        return $ci->encrypt->encode($post,$key);

    }
    function decode($post){
       $key =  "KELURAHANRENON2022SKRIPSIBARU109231283##";
       $ci = & get_instance();
       return $ci->encrypt->decode($post,$key);
       
       
   }

    if (!function_exists('tanggal')) {
        function tanggal($date){
          date_default_timezone_set('Asia/Makassar');
          // array hari dan bulan
        //   $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
           $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        // $Bulan = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
          
          // pemisahan tahun, bulan, hari, dan waktu
          $tahun = substr($date,0,4);
          $bulan = substr($date,5,2);
          $tgl = substr($date,8,2);
          $waktu = substr($date,11,5);
          $hari = date("w",strtotime($date));
        //   $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
        $result =$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun;
      
          return $result;
        }
      }
    function haribali($date){
        $Hari = array("Redite","Soma","Anggara","Budha","Wraspati","Sukra","Saniscara");
        $hari = date("w",strtotime($date));
        return $Hari[$hari];
    }
    function limitString($text,$limit){
        if(strlen($text)>$limit){
            $text = substr($text,0,$limit);
            $text = $text.'...';
        }else{
            $text = $text;
        }
        return $text;
    }
    function pancawara($tgl2){
        $tgl1 = "2010-03-01";  
 
        // ingin mengetahui apa nama hari pasaran untuk tanggal 2 April 2010
      
         
        // array urutan nama hari pasaran dimulai dari 'Pon' 
        $pasaran = array('Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing');
        
         
        // proses mencari selisih hari antara kedua tanggal 
        $pecah1 = explode("-", $tgl1);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
          
        $pecah2 = explode("-", $tgl2);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];
          
        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
          
        $selisih = $jd2 - $jd1;
         
        // hitung modulo 5 dari selisih harinya
        $mod = $selisih % 5;
         
        // menampilkan nama hari pasaran, yaitu elemen ke-$mod dari array $pasaran 
        return $pasaran[$mod]; 

    }
    function generatePelayananNo(){
        $ci = & get_instance();
        $pre = date("ym",time());	
        $query = " SELECT * FROM pelayanan_masyarakat WHERE pm_no LIKE '$pre%' ORDER BY pm_no DESC LIMIT 1";
        $query = $ci->db->query($query);
        $rsv_no = "$pre"."0000";
        foreach($query->result() as $row){
            $rsv_no = $row->pm_no;
        }
        $rsv_no = intval($rsv_no) + 1;
        return  $rsv_no;
		
    }
    function pushTelegram($message)
	    {
        $token = "5203341549:AAFclRxgx7Qc55TVwDO7mT_CesP8U5uakO8";
        $chat_id = "@kelurahanrenon";
        # keep away from banned due to max 20 mesg per mins    
		$timeexecute = rand(10,30);
		sleep($timeexecute);
		
		$strtofind = array("<br>", "<br/>", "<br />");
		$message = str_replace($strtofind, "\r\n", $message);
		
		# formating test to url mesg
	    $data = array(
		
			'text' => $message,
			'chat_id' => $chat_id,
			'parse_mode'=>'markdown',
			
		);
	    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=markdown&chat_id=".$chat_id;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);   
		 // file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?" . http_build_query($data));
	}
      function pushNotification($level,$title,$deskripsi,$link,$type,$access,$id){
        $headKey= 'FLYHELIBALI2022#%$#*@(SAD<MZN$(SLD$#';
        $ci = & get_instance();
       
        if($id != null){
            $where = "AND users_id = ".$id;
        }else{
            $where = "";
        }
        $cek = $ci->db->query("SELECT * FROM users a JOIN users_modul b ON a.users_id = b.umod_users_id JOIN submodul c ON b.umod_submodul_id = c.submodul_id WHERE users_level = '$level' AND users_active = 'y' AND submodul_link = '$access' $where");
        
       
        if($cek->num_rows() > 0){
            foreach($cek->result_array() as $row) {
                $data['notif_users_id'] = $row['users_id'];
                $data['notif_'] = $title;
                $data['notif_desc'] = $deskripsi;
                $data['notif_link']  = $link; 
                $data['notif_read'] = 'n';
                $data['notif_type'] = $type;
                $ci->db->query("INSERT INTO `notifications`(`notif_users_id`, `notif_title`, `notif_desc`, `notif_link`, `notif_read`, `notif_type`) 
                                VALUES ('".$row['users_id']."','".$title."','".$deskripsi."','".$link."','n','".$type."') ");

            }
        }

        
    }
}