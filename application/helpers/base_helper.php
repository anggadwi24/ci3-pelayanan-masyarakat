<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); {
    function theme(){
        return base_url('template/admin');
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
    function keys(){
        return "KELURAHANRENON2022SKRIPSIBARU109231283##";
    }
    function __session(){
        $ci = & get_instance();
        $sess = $ci->session->userdata('internal');
        if($sess){
            $key =  "KELURAHANRENON2022SKRIPSIBARU109231283##";
            $id =  $ci->encrypt->decode($ci->session->userdata['internal']['id'],$key);
            if($id != 0 || $id != null){
                $__cek = $ci->db->query("SELECT * FROM users WHERE users_id = ".$id."");
                if($__cek->num_rows() > 0 ){
                    
                }else{
                    $flash = $ci->session->set_flashdata('message','Login terlebih dahulu untuk mengakses halaman ini');
                    redirect('internal/auth',$flash);
                }
            }else{
                $flash = $ci->session->set_flashdata('message','Login terlebih dahulu untuk mengakses halaman ini');
                redirect('internal/auth',$flash);

            }
        }else{
            $flash = $ci->session->set_flashdata('message','Login terlebih dahulu untuk mengakses halaman ini');
            redirect('internal/auth',$flash);

        }
    }
    if (!function_exists('tanggal')) {
        function tanggal($date){
          date_default_timezone_set('Asia/Makassar');
          // array hari dan bulan
        //   $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        //   $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $Bulan = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
          
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
      if (!function_exists('fullDate')) {
        function fullDate($date){
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
    function pushEmail($email,$title,$content){
        require_once ('vendor/phpmailer/phpmailer/src/Exception.php');
        require_once ('vendor/phpmailer/phpmailer/src/PHPMailer.php');
        require_once ('vendor/phpmailer/phpmailer/src/SMTP.php');
    
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host     = 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'anggarenon12@gmail.com';
        $mail->Password = 'renon124';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('anggarenon12@gmail.com', 'Kelurahan Renon');
        $mail->addReplyTo('anggarenon12@gmail.com', 'Kelurahan Renon');
        // Add a recipient
        $mail->addAddress($email);

        // Add cc or bcc 
        $mail->addCC($email);
        $mail->addBCC($email);

        // Email subject
        $mail->Subject = $title;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
     
        $mail->Body = $content;
        $mail->AltBody = $title;
      


        // Send email
        if(!$mail->send()){
           return false;
        }else{
          return false;
         

        }
        // print_r($status);

    }
    function pushEmailAttach($email,$title,$content,$attach,$attachName){
        require_once ('vendor/phpmailer/phpmailer/src/Exception.php');
        require_once ('vendor/phpmailer/phpmailer/src/PHPMailer.php');
        require_once ('vendor/phpmailer/phpmailer/src/SMTP.php');
    
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host     = 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'anggarenon12@gmail.com';
        $mail->Password = 'renon124';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('anggarenon12@gmail.com', 'Kelurahan Renon');
        $mail->addReplyTo('anggarenon12@gmail.com', 'Kelurahan Renon');
        // Add a recipient
        $mail->addAddress($email);

        // Add cc or bcc 
        $mail->addCC($email);
        $mail->addBCC($email);

        // Email subject
        $mail->Subject = $title;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
     
        $mail->Body = $content;
        $mail->AltBody = $title;
        $mail->addStringAttachment($attach, $attachName);
      


        // Send email
        if(!$mail->send()){
           return false;
        }else{
          return false;
         

        }
        // print_r($status);

    }
    function pdf_create($html, $filename='', $paper, $orientation, $stream=TRUE)
        {
            require_once("dompdf/dompdf_config.inc.php");
        
            $dompdf = new DOMPDF();
            $dompdf->set_paper($paper,$orientation);
            $dompdf->load_html($html, 'UTF-8');
            $dompdf->render();
            
            if ($stream) {
                $dompdf->stream($filename.".pdf", array ('Attachment' => 0));
            } else {
                return $dompdf->output();
            }
        }
    function genderIndo($gender){
        if($gender == 'male'){
            return 'Laki - laki';
        }else{
            return 'Perempuan';
        }
    }
        function terbilang($x){
            $abil = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
            if ($x < 12)
              return " " . $abil[$x];
            elseif ($x < 20)
              return Terbilang($x - 10) . " Belas";
            elseif ($x < 100)
              return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
            elseif ($x < 200)
              return " Seratus" . Terbilang($x - 100);
            elseif ($x < 1000)
              return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
            elseif ($x < 2000)
              return " Seribu" . Terbilang($x - 1000);
            elseif ($x < 1000000)
              return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
            elseif ($x < 1000000000)
              return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
          }
    function insert_log($act){
        $ci = & get_instance();
        $id = $ci->session->userdata['logged_in']['ui_id'];
        $ip = get_client_ip();
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      
        $ci->db->query("INSERT INTO user_log  (`ui_id`,`ip`,`action`,`link`) VALUES ('".$id."','$ip','".$act."','".$link."') ");
    }
    function get_client_ip()
    {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress;
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
    function __ceksess($url){
        $ci = & get_instance();
        $key =  "KELURAHANRENON2022SKRIPSIBARU109231283##";
        $id =  $ci->encrypt->decode($ci->session->userdata['internal']['id'],$key);
        $session = $ci->db->query("SELECT * FROM modul,submodul,users_modul WHERE submodul.submodul_id=users_modul.umod_submodul_id AND users_modul.umod_users_id='$id' AND (submodul.submodul_link='$url' OR modul.modul_url ='$url')")->num_rows();
        if ($session == '0' ){
            $flash = $ci->session->set_flashdata('message','Anda Tidak dapat Mengakses Halaman Ini!');
    		redirect('internal/dashboard',$flash);
           
        }
    }
    function __ceksesskonten($url){
        $ci = & get_instance();
        $key =  "KELURAHANRENON2022SKRIPSIBARU109231283##";
        $id =  $ci->encrypt->decode($ci->session->userdata['internal']['id'],$key);
        $session = $ci->db->query("SELECT * FROM modul,submodul,users_modul WHERE submodul.submodul_id=users_modul.umod_submodul_id AND users_modul.umod_users_id='$id' AND (submodul.submodul_link='$url' OR modul.modul_url ='$url')")->num_rows();
        if ($session > 0 ){
            return true;
           
        }else{
            return false;
        }
    }
    function lastExplode($elem,$str){
        return substr($str, strrpos($str, $elem) + 1);
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
    function lastTime($datetime, $full = false) {
        // $today = time();    
        $today = new DateTime(date('Y-m-d H:i:s'));
        $diffDay = $today->diff(new DateTime($datetime));
      
        $difftext="";  
        $years = $diffDay->y;
        $months = $diffDay->m;
        $days = $diffDay->d;
        $hours = $diffDay->h;
        $minutes = $diffDay->i;
        $seconds = $diffDay->s;
      
        if($difftext=="")  
        {  
          if($years>1)  
           $difftext=$years." Tahun";  
          elseif($years==1)  
           $difftext=$years." Tahun";  
        }  
        //month checker  
        if($difftext=="")  
        {  
           if($months>1)  
           $difftext=$months." Bulan";  
           elseif($months==1)  
           $difftext=$months." Bulan";  
        }  
        //month checker  
        if($difftext=="")  
        {  
           if($days>1)  
           $difftext=$days." Hari";  
           elseif($days==1)  
           $difftext=$days." Hari";  
        }  
        //hour checker  
        if($difftext=="")  
        {  
           if($hours>1)  
           $difftext=$hours." Jam";  
           elseif($hours==1)  
           $difftext=$hours." Jam";  
        }  
        //minutes checker  
        if($difftext=="")  
        {  
           if($minutes>1)  
           $difftext=$minutes." Menit";  
           elseif($minutes==1)  
           $difftext=$minutes." Menit";  
        }  
        //seconds checker  
        if($difftext=="")  
        {  
           if($seconds>1)  
           $difftext=$seconds." Detik";  
           elseif($seconds==1)  
           $difftext=$seconds." Detik";  
        }  
        return $difftext;  
       }
}?>