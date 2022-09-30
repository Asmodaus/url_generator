<?php
	function row($table,$id)
    {
		$CI =& get_instance();	
		$r= $CI->db->get_where($table,array('id'=>(int)$id))->row_array(); 
		
		if ($table=='pay_methods')
		{
			 
				$dayofweek = date('w', time());
				if ($dayofweek==0) $dayofweek=7;
				
				$row = $CI->db->query("SELECT * FROM action WHERE `d{$dayofweek}`>'0'  ORDER BY id ASC LIMIT 1")->row_array();
				if (isset($row['com'])) $r['our_com']= $row['com'];
			 
		}
		
		return $r;
    }
	
	function number_format2($i,$o=0)
	{
		return ceil($i*100)/100;
	}
	
	function getRequestHeaders() {
		$headers = array();
		foreach($_SERVER as $key => $value) {
			if (substr($key, 0, 5) <> 'HTTP_') {
				continue;
			}
			$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
			$headers[$header] = $value;
		}
		return $headers;
	}
	 
	
	function echo_timer($time,$div,$command='',$notimer=0)
    { 
        ?>
        <script>
        var nowTime = Math.round(new Date().getTime() / 1000);
        warTime<?=$div?>=<?=$time?>+nowTime;
							delete timer<?=$div?>;
							 
							timer<?=$div?> = function()
							{ 
                                    var nowTime = Math.round(new Date().getTime() / 1000);
									if(warTime<?=$div?> - nowTime < -2){
										$('#<?=$div?>').remove(); 
										<?=$command?> 
									}else{  
										var day = parseInt((warTime<?=$div?>- nowTime) / 86400);
										var dayRes = (warTime<?=$div?> - nowTime) % 86400;
										if(day < 1) day = '';
										var hour = parseInt(dayRes / 3600);
										var hourRes = dayRes % 3600;
										if(hour < 1) hour = '0';
										var minute = parseInt(hourRes / 60);
										var minuteRes = hourRes % 60;
										if(minute < 10) minute = '0' + minute;
										var second = parseInt(minuteRes);
										if(second < 10) second = '0' + second;
										//element.innerHTML = day + ', ';
										var day = day + ' ' + hour +  ':' +  minute +  ':' + second;
										if (warTime<?=$div?> - nowTime  > 0 ) $('#<?=$div?>').html(day);
										//$(this).text(day);
                                        <?if ($notimer==0):?>
										timeout<?=$div?> = setTimeout(timer<?=$div?>, 1000);
                                        <?endif;?>
									}		  				
							}
							setTimeout(timer<?=$div?>, 1);
        </script>
         <?
    }
 
	  
function GetSignature($key, $message){
    return strtoupper(hash_hmac('sha256', pack('A*', $message), pack('A*', $key)));
}
    

	
	function getHumanTimeDiff($strTime) {
		$dtNow = time();
		$dtTime = strtotime($strTime); 
		$diff = $dtNow - $dtTime;
	 
		if ($diff >= 0 && $diff < 15) { 
			return l('только что');
		} else if ($diff >= 15 && $diff < 60) {
			// разница меньше минуты => ...секунд назад
			return $diff . " " . l('сек. назад');
		} else if ($diff >= 60 && $diff < 3600) {
			// разница меньше часа => ...минут назад
			return floor($diff/60) . " " . l('мин. назад.');
		} else if ($diff >= 3600 && $diff < 86400) {
			// разница меньше суток => ...часов назад
			return floor($diff/3600) . " " . l('ч. назад');
		} else if ($diff >= 86400 && $diff < 2592000) {
			// разница меньше месяца => ...дней назад
			return floor($diff/86400) . " " . l('дн. назад');
		} else if ($diff >= 2592000) {
			// разница меньше года
			return l('более месяца назад');
		}
	 
		return '';
	}
	
	function time_dif($diff)    
	{
		if ( $diff / 3600/24>1)
			return sprintf('%2d days %02d:%02d:%02d', $diff / 3600/24, $diff / 3600, ($diff % 3600) / 60, $diff % 60);
		else return sprintf('%02d:%02d:%02d',  $diff / 3600, ($diff % 3600) / 60, $diff % 60);
	}
	
	function get_all_array($arr,$key_val='id',$name_val='name')
	{
		$list=array();
		foreach ($arr as $row) $list[$row[$key_val]]=$row[$name_val];
		return $list;
	}
	
	function generate_url($v)
	{
		$str = mb_strtolower(translit(str_replace(' ','-',str_replace(array('.','(',')','&','\\',"'" ),'',$v))),'utf-8');
		$str = str_replace('----','-',$str);
		$str = str_replace('---','-',$str);
		$str = str_replace('--','-',$str);
	
		$str = preg_replace("[^-a-zA-Z0-9]", "", $str); 
		return $str;
	}
	
	function l($word,$lang='')//автоперевод
	{
		$key=translit($word);
	 
		$CI =& get_instance();	
		if (isset($CI->CI)) $CI=$CI->CI;//значит вызвали из класса
		if (strlen($lang)>0)
		{
			$CI->lang->load('site_lang', $lang);
		}
		elseif (count($CI->lang->is_loaded)==0) { 
			$CI->lang->load('site_lang', (new Users($CI))->get_url_language());
		}
		
		$word2=$CI->lang->line($key);
		//echo (new Users($CI))->get_url_language().'.--'.$key.'==='.$word2;
		if (strlen($word2)>0) return $word2;
		//
		 
		if (count($CI->lang->is_loaded)>0)
		{
			foreach ($CI->lang->is_loaded as $file =>$lang)
				$basepath =  './application/language/'.$lang.'/'.$file;
			//значит создаем в файл новое слово
			$txt = '$lang["'.$key.'"]="'.$word.'";';
			$myfile = file_put_contents($basepath, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);	
			
		}
		else {
			echo ('error use lang file'); 
		}
			
			
		 
		
		
		
		
		return $word;
	}
	
	function base_domain()
	{
		$url = str_replace('https:','',base_url());
		$url = str_replace('http:','',$url);
		$url = str_replace('/','',$url);
		return $url;
	}
	
	function vars($key)
	{
		$CI =& get_instance();	
		
		$option=$CI->db->get_where('options',array('key'=>$key))->row_array();
		
		if ($key=='btc_com')
		{
			$dayofweek = date('w', time());
			if ($dayofweek==0) $dayofweek=7;
			
			$row = $CI->db->query("SELECT * FROM action WHERE `d{$dayofweek}`>'0'  ORDER BY id ASC LIMIT 1")->row_array();
			if (isset($row['com'])) return $row['com'];
		}
		
		return $option['value'];
	}
	
	function send_mail2($who,$theme,$text,$from)
	{
		$headers = 'Content-type: text; charset=UTF-8' . "\r\n";
		// Дополнительные заголовки
		$headers .= 'From: '.$from . "\r\n"; 
		mail($who, $theme,$text, $headers);					
	}
	
	function send_mail_stmp($to,$tema,$text,$bcc='',$from_name='') 
	{

		return send_mail2($to,$tema,$text,$from_name);
		$CI =& get_instance();	
		$config = Array(
			'protocol' => 'sendmail',
			//'protocol' => 'smtp', 
			//'smtp_host' => 'ssl://m.transcoin.me',
			//'smtp_host' => 'ssl://127.0.0.1',
			//'smtp_host' => '127.0.0.1',
			//'smtp_port' => 587,
			//'smtp_timeout' => 7,
			//'smtp_user' => 'no-reply@transcoin.me',
			//'smtp_pass' => 'ItK5qhHI1sWli2Qz',
			'mailtype'  => 'html',
			'mailpath'  => '/usr/sbin/sendmail', 
			//'smtp_crypto'  => 'tls', 
			//$config['starttls'] = true;
			//$config['bcc_batch_mode'] = true;
			//$config['bcc_batch_size'] = 200;
			'bcc_batch_mode' => 'true',
			'bcc_batch_size' => '200',
			'charset'   => 'utf-8'
		);
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");

		$CI->email->from($from_name, $from_name);
        $CI->email->to($to);
        //$CI->email->bcc('65e196f1bd@invite.trustpilot.com'); 
		if (strlen($bcc)) $CI->email->bcc($bcc);
        $CI->email->subject($tema);
        $CI->email->message($text);  

		  $result = $CI->email->send();
		 if (!$result) $CI->email->print_debugger();
	}
	
	function get_ip()
	{
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		elseif (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		$ip2=explode(',',$ip);
		if (count($ip2)>1) return trim($ip2[0]);
		return $ip;
	}


	function check()
    {
		$CI =& get_instance();	
		$user_id=$CI->session->userdata('user_id'); 
		if (isset($user_id)) 
		{
			$user =  new Users($CI,(int)$user_id);
			$user->last_ip_access=$user->ip=get_ip();
			if ($user->id>0) {
				if ($CI->input->get('remember'))
				{ //постановка куки после авторизации в силу того что при авторизации чрез аякс на куки ставятся ограничения
					$CI->input->set_cookie('user_id', $user->id, 30*24*3600, base_domain() , '/' );
					$CI->input->set_cookie('hash', md5($user->password.$user->email), 30*24*3600, base_domain() , '/' );
				} 
				if ($user->id>0)
				{
					$user->last_access=time(); 
					$user->save();
				}
				return $user;
			} 
		}
		if (isset($_GET['hex'])) 
		{
			$user =  new Users($CI,(int)$_GET['usid']);
			$user->ip=get_ip();
			if ($user->id>0 && $user->password==$_GET['hex']) {
				 
				$user->set_session(); 
				$user->last_access=time();
				$user->save();
				 
				return $user;
			} 
		}
		$user = new Users($CI);
		
		$user->check_cookie();
		if ($user->id>0)
		{
			$user->last_access=time();
			$user->save();
		}
		
		
		return $user; 
    }
	
	function array_merge2($arr1,$arr2)
	{
		 
		foreach ($arr1['result']['ledger'] as $v) $arr2['result']['ledger'][]=$v;
		return $arr2;
	}
	
	function mysql_check($params)
	{
		$CI =& get_instance();	
		
		foreach ($params as $k=>$v) $params[$k]=$CI->db->escape_str($v);
		return $params;
	}
	
    function redirect_js($url)
	{
		$_SESSION['last_page']= $_SERVER['REQUEST_URI'];
		echo '<script>window.location="'.$url.'";</script>';
	}	
	
	function redirect2($url)
	{
		$_SESSION['last_page']= $_SERVER['REQUEST_URI'];
		Header ('Location: '.$url);
		die();
		redirect($url);
	}	
	
    function translit($urlstr,$isk='_') 
	{
		 
			
			$tr = array(
				"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
				"Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
				"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
				"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
				"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
				"Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
				"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
				"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
				"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
				"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
				"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
				"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
				"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
				" "=> "_",  "ё"=>"e" , "'"=>"",'ö'=>'o','/'=>'-','ü'=>'u'
			);
			$tr[$isk]=$isk;
			$urlstr = strtr($urlstr,$tr);
			
		
		return $urlstr;
		
	}
	
	function kol($kol,$drob=0)
    {
        
        if ($kol>10000000000000) { $str=(int)($kol/1000000000000); $str.='mm'; }
        elseif ($kol>10000000000) { $str=(int)($kol/1000000000); $str.='mk'; }
        elseif ($kol>10000000) { $str=(int)($kol/1000000); $str.='kk'; }
        elseif ($kol>10000) { $str=(int)($kol/1000); $str.='k'; } 
        elseif ($kol>1) $str=(int)$kol;
        elseif ($kol<-1) $str=(int)$kol;
        elseif ($kol>0.01 && $drob==1) $str=(int)($kol*100)/100;
        elseif ($drob==1)   $str=(int)($kol*10000)/10000;
        else $str=(int)$kol;
        return $str;
    }
	
	function check_recapcha($response)
	{
		$res = Send_Post('https://www.google.com/recaptcha/api/siteverify',  array('secret'=>GOOGLE_RECAPCHA_SECRET,'response'=>$response,'remoteip'=>get_client_ip()), base_url());
		$res=json_decode($res);
		if ($res->success) return true;
		return false;
	}
	
	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	 
	function google_api($geocode,$additional_args='')
	{
		global $Google_API_KEY;
		
		$r=Send_Post('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geocode.$additional_args.'&language=en&key='.$Google_API_KEY);
		
		if (strlen($r)<1) return false;
		$r2=json_decode($r);
		$res=$r2->results;
		 
		return $res;
	} 
	 
	 
	function yandex_api($geocode,$additional_args='')
	{
		global $Yandex_API_KEY;
		
		//die('https://geocode-maps.yandex.ru/1.x/?geocode='.$geocode.'&format=json&kind=street&lang=en_US&key='.$Yandex_API_KEY.$additional_args); 
		 $r=Send_Post('https://geocode-maps.yandex.ru/1.x/?geocode='.$geocode.'&format=json&kind=street&lang=en_US&key='.$Yandex_API_KEY.$additional_args);
		//file_get_contents('https://geocode-maps.yandex.ru/1.x/?geocode='.$geocode.'&format=json&kind=street&lang=en_US&key='.$Yandex_API_KEY.$additional_args);
		 
		if (strlen($r)<1) return false;
		$r2=json_decode($r);
		return $r2->response->GeoObjectCollection;
	}
	
	function Send_Post($post_url, $post_data=array(), $refer='') 
	{ 
	  $ch = curl_init(); 
	  curl_setopt($ch, CURLOPT_URL, $post_url); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  if (strlen($refer)>0) curl_setopt($ch, CURLOPT_REFERER, $refer); 
	 
	  if (count($post_data)) {
		   curl_setopt($ch, CURLOPT_POST, 1); 
		   curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
	  }
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); 
	  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17'); 
	  
	  $data = curl_exec($ch); 
	  curl_close($ch); 
	  
	  return $data; 
	} 
	
	function SocialAuthInit($socials='vk,odnoklassniki,mailru,yandex,google,facebook',$redurect_uri='')
	{
		if (strlen($redurect_uri)<1) $redurect_uri=URI_PROTOCOL.base_domain().'/site/oauth'; 
		
		$adapterConfigs = array(
			'vk' => array(
				'client_id'     => '6270213',
				'client_secret' => 'oGuq23XcatThwgo3O3m0',
				'redirect_uri'  => $redurect_uri.'?provider=vk'
			),
			'odnoklassniki' => array(
				'client_id'     => '168635560',
				'client_secret' => 'C342554C028C0A76605C7C0F',
				'redirect_uri'  =>  $redurect_uri.'?provider=odnoklassniki',
				'public_key'    => 'CBADCBMKABABABABA'
			),
			'mailru' => array(
				'client_id'     => '770076',
				'client_secret' => '5b8f8906167229feccd2a7320dd6e140',
				'redirect_uri'  => $redurect_uri.'?provider=mailru'
			),
			'yandex' => array(
				'client_id'     => 'bfbff04a6cb60395ca05ef38be0a86cf',
				'client_secret' => '219ba8388d6e6af7abe4b4b119cbee48',
				'redirect_uri'  =>  $redurect_uri.'?provider=yandex'
			),
			'google' => array(
				'client_id'     => '670717055380-n8l7lhntov9nhcfnrsfp7tu62jeu6ivs.apps.googleusercontent.com',
				'client_secret' => 'ViMnyMImXYipCXE7fuBKmcuh',
				'redirect_uri'  =>  urlencode($redurect_uri.'?provider=google')
			),
			'facebook' => array(
				'client_id'     => '2148756792018316',
				'client_secret' => 'b54c377cf3adee72449bb42f0591d5e6',
				'redirect_uri'  => $redurect_uri.'?provider=facebook'
			),
			'twitter' => array(
				'client_id'     => 'KpOGcJ6aR9t2ihVDL6YjrfY8y',
				'client_secret' => 'HAezQtiLCgNAqgUh0x9Z0QC0RDQlkxvvoPaDPmOsx7RwLhyxfj',
				'redirect_uri'  => $redurect_uri.'?provider=twitter'
			)
			,
			'instagram' => array(
				'client_id'     => 'ef054ab66c0538b39e0a865cf',
				'client_secret' => '6d6c0538b39e0a86cf219ba88d386b114b9c6abef7eab4e8e4',
				'redirect_uri'  => $redurect_uri.'?provider=instagram'
			)
		);
		
		$socials=explode(',',$socials); 
		$adapters = array();
		foreach ($adapterConfigs as $adapter => $settings) if (in_array($adapter,$socials)) {
			$class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
			$adapters[$adapter] = new $class($settings);
		}
		
		return $adapters;
	}
	
	function SocialAuth($socials='vk,odnoklassniki,mailru,yandex,google,facebook',$redurect_uri='')
	{
		$adapters=SocialAuthInit($socials,$redurect_uri);
		  
		foreach ($adapters as $title => $adapter) { 
			echo '<li><a href="' . $adapter->getAuthUrl() . '"><i class="fa fa-'.$title.'-official fa-3x" aria-hidden="true"></i></a></li>';
		}
		

	}
	
	function send_sms($number,$text)
	{
		$CI =& get_instance();	
		if (isset($CI->CI)) $CI=$CI->CI;
		
		$sid    = $CI->config->item('sms_sid');
		$token  = $CI->config->item('sms_token');
		$twilio = new Twilio\Rest\Client($sid, $token); 
		
		 
		$message = $twilio->messages
						  ->create($number, // to
						array("from" => $CI->config->item('sms_from'), "body" => $text)
		); 
		 
		 
		return;

		if (strlen($number)<6) return false;
		//Send_Post('https://new.sms16.ru/get/timestamp.php');// 
        $time=(int)file_get_contents('https://new.sms16.ru/get/timestamp.php');//time();
		
        $login = "kratospay";
         if (substr($number,0,1)=='+') $number=substr($number,1);
        $params = array(
            'timestamp' => $time,
            'login'     => $login,
            'phone'     => $number,
            'sender'     => urlencode('5bit'),
            'text'      => $text,
            'return' => 'json'
            
        );
		 
         $text =  urlencode($text);
        ksort( $params );
        reset( $params );
         
          $p = implode( $params ).'a498430d3a8f128646f51f47dd5a796870dc85f9';
        $sig  = md5($p);
          
         $urltopost="https://new.sms16.ru/get/send.php?login=".$login."&phone=".$number."&text=".$text."&return=json&sender=".$params['sender']."&timestamp=".$time."&signature=".$sig;
        $xx = file_get_contents($urltopost);// Send_Post($urltopost);//
		addlog($xx);
		 return true;
		$ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-type: text/xml; charset=utf-8' ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CRLF, true );
        curl_setopt( $ch, CURLOPT_POST, true );
        //curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
        curl_setopt( $ch, CURLOPT_URL, $urltopost );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true ); 
        $result = curl_exec($ch); 
		addlog($result);
		// die($result.'==');
		return true;
	}
	
	function table_color($num)
	{
		if ($num<0) return 'red';
		if ($num>0) return 'green';
		return '';
	}
	
	function table_val($num)
	{
		if ($num<0) return '';
		if ($num>0) return '+';
		return '';
	}
	
	function addlog($text,$file='log.txt',$kraken=0)
    {
        $CI =& get_instance();	
		if (isset($CI->CI)) $CI=$CI->CI;
		
	 
		if ($kraken==1) $CI->db->insert('log_kraken',array('time'=>time(),'text'=>$text));
		else $CI->db->insert('log',array('time'=>time(),'text'=>$text));
		
        $fp = fopen($file, 'a');
		
		//$new_text = (is_string($text)) ? $text : json_encode($text, JSON_UNESCAPED_UNICODE);
        fwrite($fp,"\r\n".date('d.m.Y H:i:s'). '  '.$text);
        
        fclose($fp);
		
		 
    }
	
	function slack($message, $channel )
	{
  if($channel == '#notifications'){$channel = 'https://hooks.slack.com/services/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';}	
  if($channel == '#document_new'){$channel = 'https://hooks.slack.com/services/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';}	
  if($channel == '#exchange'){$channel = 'https://hooks.slack.com/services/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';}	
  if($channel == '#exchange_accept'){$channel = 'https://hooks.slack.com/services/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';}	
  if($channel == '#declined_payment'){$channel = 'https://hooks.slack.com/services/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';}	
	
  define('SLACK_WEBHOOK', $channel);
  $msg = array('text' => $message);
  $c = curl_init(SLACK_WEBHOOK);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($c, CURLOPT_POST, true);
  curl_setopt($c, CURLOPT_POSTFIELDS, array('payload' => json_encode($msg)));
  curl_exec($c);
  curl_close($c);  
	}
	 
	
		function addlog_new($text,$file='log.txt')
    {
        $CI =& get_instance();	
		if (isset($CI->CI)) $CI=$CI->CI;
		
		//$CI->db->insert('log',array('time'=>time(),'text'=>$text));
		//if ($kraken==1) $CI->db->insert('log_kraken',array('time'=>time(),'text'=>$text));
		
        $fp = fopen($file, 'a');
		
	// $new_text = (is_string($text)) ? $text : json_encode($text);


        ob_start();
        var_dump($text);
        $new_text = ob_get_contents();
        ob_end_clean();



		


        fwrite($fp,"\r\n".date('d.m.Y H:i:s'). '  '.$new_text);
        
        fclose($fp);
		 
		
		
    }
 
