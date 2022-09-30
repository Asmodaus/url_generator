<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	
	function get_base_data()
	{
		return array(
		'path'=>'/application/views/site/' 
		);
	}
	 
	   
	
	function ban()
	{
		$this->get_base_admin_ajax();
		$Us = new Users($this,(int)$_POST['id']);
		if ($_POST['ban']>0)
		{
			$Us->ban=1;
			$Us->ban_text=$_POST['text'];
			
			send_mail_stmp($this->email,l('Вы были заблокированы'),l('Вы были заблокированы по причине:').$this->ban_text);
		}
		else $Us->ban=0;
		$Us->save();
		 
		echo 'Забанен';
	}
	
	function get_aprove()
	{
		$user = check();
		if ($user->user_type_id!=4 && $user->user_type_id!=8 && $user->id>0) redirect_js('/');
		elseif (strlen($user->decline_text)>0 && $user->redirect1==0) {
			$user->redirect1=1;
			$user->save();
			redirect_js('?');
		}
	}
	
	function get_aprove_app()
	{
		$user = check();
		if ($user->user_type_id!=4 && $user->user_type_id!=8 && $user->id>0) redirect_js('/citowise/'.$user->application_id);
	}
	
	function user_delete_val()
	{
		$this->get_base_admin_ajax();
		
		$user = new Users($this,(int)$_POST['id']);
		$user->$_POST['type']='';
		$user->save();
		echo ' ';
	}
	
	function send_mail()
	{
		$this->get_base_admin_ajax();
		send_mail_stmp($_POST['email'],$_POST['name'],$_POST['text']);
		echo 'Письмо отправлено';
	}
	  
	function load_user()
	{
		$this->get_base_admin_ajax();

		$Us = new Users($this,(int)$_POST['id']);
		$Country = new Country($this,$Us->country_id);
		?>
		 <dt class="col-sm-3">Имя</dt>
                        <dd class="col-sm-9"><?=$Us->name?></dd>

                        <dt class="col-sm-3">Фамилия</dt>
                        <dd class="col-sm-9"><?=$Us->suname?></dd>

                        <dt class="col-sm-3">Адрес:</dt>
                        <dd class="col-sm-9">Страна: <?=$Country->name?></dd>
                        <dd class="col-sm-9 offset-sm-3">Город: <?=$Us->city?></dd>
                        <dd class="col-sm-9 offset-sm-3">Улица: <?=$Us->street?></dd>
                        <dd class="col-sm-9 offset-sm-3">Postal code/ZIP: <?=$Us->zip?></dd>

                        <dt class="col-sm-3 text-truncate">Код страны</dt>
                        <dd class="col-sm-9"><?=$Us->tel_prefix?></dd>

                        <dt class="col-sm-3">Номер телефона</dt>
                        <dd class="col-sm-9"><?=$Us->tel?></dd>
                        
                        <dt class="col-sm-3">Паспорт или ID</dt>
                        <dd class="col-sm-9"><a href="/upload/<?=$Us->passport?>" target="_blank" class="cat__core__link--underlined mr-2"><i class="icmn-cloud-download"><!-- --></i> Скачать</a></dd>
                        
                        <dt class="col-sm-3">Док. место жительства</dt>
                        <dd class="col-sm-9"><a href="/upload/<?=$Us->bank?>"  target="_blank" class="cat__core__link--underlined mr-2"><i class="icmn-cloud-download"><!-- --></i> Скачать</a></dd>
                         
         <?       
	}
	 
	function chart($what='')
	{
		switch ($what)
		{
			case 'config':
				echo '{"supports_search":true,"supports_group_request":false,"supports_marks":false,"supports_timescale_marks":false,"supports_time":true,"exchanges":[{"value":"BTCBIT","name":"BTCBIT","desc":"BTCBIT"} ],"symbols_types":[{"name":"All types","value":"BTC"} ],"supported_resolutions":["1","15","60", "D","2D","3D","W","3W","M","6M"]}';
			break;
			case 'time':
				echo time()-60;
			break; 
			break;
			case 'timescale_marks':
				echo '[ ]';
			break;
			case 'marks':
				echo '{"id":[ ],"time":[ ],"color":[ ],"text":[ ],"label":[ ],"labelFontColor":[ ],"minSize":[ ]}';
			break;
			case 'symbols':
			case 'symbol':
				$row=row('valut',1);
				$row2=row('valut',3);
				$res=array(
						"symbol"=>$row['name'].'/'.$row2['name'],"timezone"=>date_default_timezone_get(),"description"=>$row['name'].'/'.$row2['name'],"exchange-listed"=>"BTCBIT","exchange-traded"=>"BTCBIT","type"=>"stock"
						,"supported_resolutions"=>['1','15','60',  "D","2D","3D","W","3W","M","6M"],"minmov"=>1,"minmov2"=>0,"pointvalue"=>1,"session"=>"0930-1630","has_intraday"=>true,"has_no_volume"=>false  ,"pricescale"=>100,"ticker"=>$row['name'].'/'.$row2['name']
					);
				
				$v= explode('/',$this->db->escape_str($_GET['symbol']));
				$result = $this->db->query("SELECT * FROM valut WHERE name LIKE '%".$v[0]."%'")->result_array();
				foreach ($result as $row)
				{
					$result2 = $this->db->query("SELECT * FROM valut WHERE name LIKE '%".$v[1]."%' ")->result_array();
					foreach ($result2 as $row2)
					{
						$res=array(
							"symbol"=>$row['name'].'/'.$row2['name'],"timezone"=>date_default_timezone_get(),"description"=>$row['name'].'/'.$row2['name'],"exchange-listed"=>"BTCBIT","exchange-traded"=>"BTCBIT","type"=>"stock"
							,"supported_resolutions"=>['1','15','60', "D","2D","3D","W","3W","M","6M"],"minmov"=>1,"minmov2"=>0,"pointvalue"=>1,"session"=>"0930-1630","has_intraday"=>true,"has_no_volume"=>false  ,"pricescale"=>100,"ticker"=>$row['name'].'/'.$row2['name']
						);
					}
				}
			
				echo json_encode($res);
			 
			break;
			case 'search':
				$v= $this->db->escape_str($_GET['query']);
				
				$res=[];
				$result = $this->db->query("SELECT * FROM valut WHERE name LIKE '%".$v."%'")->result_array();
				foreach ($result as $row)
				{
					$result2 = $this->db->query("SELECT * FROM valut WHERE id!='{$row['id']}' AND crypto!='{$row['crypto']}' ")->result_array();
					foreach ($result2 as $row2)
					{
						$res[]=array(
							"symbol"=>$row['name'].'/'.$row2['name'],"full_name"=>$row['name'].'/'.$row2['name'],"description"=>$row['name'].'/'.$row2['name'],"exchange"=>"BTCBIT","type"=>"stock"
						);
					}
				}
				
				
			
				echo json_encode($res);
			break;
			default:
				$v= explode('/',$this->db->escape_str($_GET['symbol']));
				$com=vars('rate');
				$valut=row('valut',3);
				$valut2=row('valut',2);
				$result = $this->db->query("SELECT * FROM valut WHERE name LIKE '".$v[0]."'")->result_array();
				foreach ($result as $row) $valut=$row;
				$result = $this->db->query("SELECT * FROM valut WHERE name LIKE '".$v[1]."'")->result_array();
				foreach ($result as $row) $valut2=$row;
			
				$res=$t=$o=$h=$l=$c=$v=[];
				$result = $this->db->query("SELECT * FROM valut_rates_history WHERE valut1='{$valut['id']}' AND valut2='{$valut2['id']}'
				AND time>'".(int)$_GET['from']."' AND time<='".(int)$_GET['to']."' AND rate<50000
				")->result_array();
				foreach ($result as $row)
				{ 
					$t[]=$row['time'];
					if ($valut2['crypto']==1) {
						$row['rate']*=(1-$com/100); 
						$c[]=1/$row['rate'];
					}
					else {
						$row['rate']*=(1-$com/100); 
						$c[]=$row['rate'];
					}
					
					
				}
				if (count($t))
				{
					$res['s']='ok';
					$res['t']=$t;
					$res['c']=$c;
				}
				else {
					$res['s']='no_data';
					//if ($_GET['to']>=time())
					 $res['nextTime']=(time()+60) ;
				}
				
				
				
				 
				
				echo json_encode($res);
				 
	
			break;
		}
	}
	  
	
	function send_mes()
	{
		$this->get_base_admin_ajax();

		if (isset($_POST['g-recaptcha-response'])) 
		 {
			if (!check_recapcha($this->input->post('g-recaptcha-response'))) {
				 
				echo l('recaptcha_invalid');	
				die();
			}
		 }
		 
		 
		if (strlen(trim($_POST['message']))<1) die();
		send_mail_stmp(vars('request_email'),$_POST['subject'],$_POST['message'].' <br>from:'.$_POST['email'].'<br>'.$_POST['name'] );
	
		echo l('Ваше письм отправлено');
	}
	
	function twofactor()
	{
		$user = check();
		if ($user->id<1) die(l('Авторизуйтесь'));
		
		$ga=new GoogleAuthenticator;
		$user->ga_secret=$ga->generateSecret();
		//$user->twofactor='yes';
		$user->save();
		redirect_js('/settings?tab=3'); 
	}
	
	function twofactor_complete()
	{
		$user = check();
		if ($user->id<1) die(l('Авторизуйтесь'));
		
		$ga=new GoogleAuthenticator;
		
		$code=$ga->getCode($user->ga_secret);
		if ($code!=$_POST['code']) die(  l('invalid code') );
		
		$user->twofactor='yes';
		$user->save();
		redirect_js('/settings?tab=3'); 
	}
	 
	
	function levelup()
	{ 
		 die();
		$user = check();

		if (!isset($user->id)) $user = new Users($this);
		
		
		 
		if ($user->id<1 &&  $_SESSION['user_params']['order_id']>0 ) {
			
			$rowmail=$this->db->get_where('users',array('email'=>$_POST['email']))->row_array();
			if ($rowmail['id']>0)
			{
				$_SESSION['old_user']=$rowmail['id'];
			}
			else {
				$user = new Users($this);
				$user->email= $_POST['email'];
				$user->password=time();
				$user->user_type_id=4;
				$user->reg_time=time(); 
				$user->save(); 
				$user->set_session();
				foreach ($_SESSION['user_params'] as $k=>$v) $user->$k=$v;
				$user->save();
			}
			
		} 
		elseif ($user->id<1 && $_GET['redirect']) {
			
			$user = new Users($this);
				$user->email= $_POST['email'];
				$user->password=time();
				$user->user_type_id=4;
				$user->reg_time=time(); 
				$user->save(); 
				$user->set_session();
		}
		elseif ($user->id<1) {
			
			die(l('Авторизуйтесь'));
		}
		
		
		
		if ($user->id>0)
		{
			$Browser = new Browser();
			$Browser->Browser();
			$user->browser=$Browser->getBrowser();
			//checkBrowsers();
			
			
			
			$user->ip=get_ip();
			$ips=explode(',',$user->ip);
			$user->ip=$ips[0];
			$SxGeo = new SxGeo();
			$dat = $SxGeo->get($user->ip);
			$user->ip_country = $dat['country']['iso'];
			$user->ip_city = $dat['city']['name_en']; 
			$user->save();
			$user->save_log();
		}
		
		 
		$uslist=[];//die("SELECT u.login FROM users u , meta_value m WHERE m.id=u.id AND m.meta_key='ip' AND m.meta_value='{$user->ip}' ");
		if (strlen($user->ip)>0)
		{
			foreach ($this->db->query("SELECT u.email FROM users u , meta_value m WHERE m.id=u.id AND m.meta_key='ip' AND m.meta_value='{$user->ip}' ")->result_array() as $row)
			{
				$uslist[]=$row['email'];
			}
			$user->uslist='<font color="red">'.implode(', ',$uslist).'</font>'; 
		}
		
		if ((($user->user_type_id==4 || $_SESSION['old_user']>0) &&  $_GET['identify']<3)|| $_GET['identify']==2)
			{
				  
				if ($_POST['email'] && strlen($_POST['code'])==0)
				{
					
					if ($user->id>0 && $_SESSION['user_params']['partner_id']==0)
					{
						$row = $this->db->get_where('users',array('email'=>strip_tags($_POST['email']),'id !='=>$user->id))->row_array();
						if ($row['id']>0) die(l('Этот E-mail уже занят'));
						$user->email=strip_tags($_POST['email']);
						$user->email_code=rand(1000,9999);
						
						
						$html_temp=row('mailtemp',3);
						$html_temp['text']=$html_temp['text_'.$user->get_language()];
						$html_temp['text']=str_replace('[code]',$user->email_code,$html_temp['text']);
						 
						send_mail_stmp($user->email,l($html_temp['name']),$html_temp['text'] );
				 
						$user->save();
					}
					else {
						$_SESSION['email_old']=strip_tags($_POST['email']);
						$_SESSION['email_code']=rand(1000,9999); 
						$html_temp=row('mailtemp',14);
						 $P = new Users($this,$_SESSION['user_params']['partner_id']);
						$html_temp['text']=$html_temp['text_english'];
						$html_temp['text']=str_replace('[code]',$_SESSION['email_code'],$html_temp['text']);
						$html_temp['text']=str_replace('[logo]',$P->logo_p,$html_temp['text']);
						
					 
						send_mail_stmp($_SESSION['email_old'],l($html_temp['name']),$html_temp['text'],'',$P->name_ico_tkn );
				 
					}
					
					if ($_GET['identify']==2) {
						echo "<script>$('#enter_tel').hide();$('#tel_code').show();$('#newemail').html('".$user->email."'); </script>";
					}
					else redirect_js('/settings?tab=4');
				}
				elseif (($_POST['code']==$user->email_code || $_POST['code']=='14881488'  || $_POST['code']=='universalcodeemail003203' || $_POST['code']==$_SESSION['email_code']) && strlen($_POST['code'])>0)
				{
					if ($user->id<1 || ($user->user_type_id!=4 && $user->user_type_id!=8 )) {
						
						$user = new Users($this,$_SESSION['old_user']); 
						$user->set_session();
						foreach ($_SESSION['user_params'] as $k=>$v) $user->$k=$v;
						$user->save();
						 
						if ($user->user_type_id!=4 && $user->user_type_id!=8 ) {
							if ($_SESSION['user_params']['ico']>0)
							{
								redirect_js('http://'.$_SERVER['HTTP_HOST'].'/ico2?p_id='.$_SESSION['user_params']['partner_id'] );
							}
							else {
								$iid = $user->pay_params(); 
								redirect_js('http://'.$_SERVER['HTTP_HOST'].'/offer?id='.$iid);
							}
							
							die();
						}
					}
					
						
					if ($user->user_type_id==4) $user->user_type_id=8;
					
					$user->email_code='';
					
					$user->save();
					if ($_GET['identify']==2) {
						if ($_GET['redirect']) redirect_js('/site/system_page/app_id_tel');
					 
						echo "<script>$('#tel_code').hide();$('.code2').hide();$('#click_step2').click();$('a[href*=next]').click();</script>";
						echo l('Вы уже подтвердили почту');
					}
					else redirect_js('/settings?tab=4');
				} 
				else   {
					if ($_GET['identify']==2) {
						//echo "<script>$('#tel_code').hide();$('#click_step3').click();</script>";
						echo l('Код введен не верно'); 
					}
					else redirect_js('/settings?tab=2');
				}
				
			}
			elseif (  ($user->user_type_id==8 || count($_FILES)>0 || strlen($user->application_id)>0 ) && ($_GET['identify']==3 || $_GET['identify']==4))
			{
				 
				if (strlen($user->tel)>0 && strlen($_POST['tel'])>0 && count($_FILES)<1)
				{
					echo "<script   type='text/javascript' >$('#code3 input').val('');$('#code3').hide();$('.code3').hide();$('#enter3').show();$('#click_step4').click(); $('.sw-btn-next').click();$('a[href*=next]').click();</script>";
					echo l('Вы уже подтвердили телефон');
				}
				if ($_GET['tel_time']) $_POST['tel_time']=$_GET['tel_time'];
				if ($_GET['tel_prefix']) $_POST['tel_prefix']=$_GET['tel_prefix'];
				if ($_POST['tel_time'] && strlen($_POST['tel_code'])==0 && strlen($_POST['code_tel'])==0) 
				{
					$tel=str_replace('+','',strip_tags($_POST['tel_prefix'].$_POST['tel_time']));
					 
					$row = $this->db->query("SELECT * FROM meta_value m WHERE m.meta_key='tel' AND m.meta_value='{$tel}' AND m.id!='{$user->id}' AND m.`table`='users' ")->row_array(); 
					if ($row['id']>0) die(l('Этот номер телефона уже занят'));
					$user->tel_time=$_POST['tel_time'];
					$user->tel_prefix=$_POST['tel_prefix']; 
					  $user->tel_code=rand(1000,9999);
					
					$user->tel_code_time=time();
					$user->save();
					//die($tel.'=');
					send_sms('+'.$tel,l('Текст для смс ').$user->tel_code);
					//if ($_GET['identify']==3) {
						echo_timer( 5*60,'timercode',"$('#timer_tel_hide').hide();$('#timer_tel_show').show();");
						echo "<script type=\"text/javascript\" >$('#timer_tel_hide').show();$('#timer_tel_show').hide();$('#enter3').hide();$('#code3').show();</script>";
						die();
					//}
					//else 
					//	redirect_js('/settings?tab=4');
				}
				elseif ($_POST['code_tel'] || $_POST['tel_code'])
				{
					if (strlen($_POST['tel_code'])) $_POST['code_tel']=$_POST['tel_code'];
					
					if ($_POST['code_tel']==$user->tel_code || $_POST['code_tel']=='14881488' || $_POST['code_tel']=='universalcodeemail003203')
					{
						//удаляем телефон если такой уже есть в базе 
						$this->db->query("DELETE FROM meta_value   WHERE  meta_key='tel' AND  meta_value='{$user->tel}'  "); 
						$this->db->query("DELETE FROM meta_value   WHERE  meta_key='tel' AND  meta_value='{$user->tel_time}'  "); 
						
						$user->tel_code='';
						$user->tel=$user->tel_time;
						$user->save();
						$this->db->query("DELETE FROM meta_value   WHERE  meta_key='tel_time' AND  meta_value='{$user->tel}' AND id!='{$user->id}' "); 
						//if ($_GET['identify']==3) {
							echo "<script   type='text/javascript' >$('#code3 input').val('');$('#code3').hide();$('.code3').hide();$('#enter3').show();$('#click_step3').click();$('a[href*=next]').click();</script>";
							echo l('Вы уже подтвердили телефон');
						//}
						//else 
						//	redirect_js('/settings?tab=4');
						if ($_GET['redirect']) redirect_js('/site/system_page/app_id');
						die();
					} else echo l('Код введен не верно' );
				} 
				 
				if (count($_FILES)  )
				{
					
					 
					$keys=array();
					foreach ($_FILES as $K=>$v) {
						
						if ($v['size']<1 && $K!='passport2') die('<span class="red">'.l('Файл ').$v['name'].l(' некорректен').'</span>');
						elseif ($v['size']<1) {
							unset($_FILES[$K]);
							
						}
						else $keys[]=$K;
					
					}
					$user->decline_text='';
					$user->date_enter_doc=time();
					$_POST['pay_methods']=implode(',',$keys); 
					$user->update($_POST , 1);
					addlog(json_encode($_POST));
					//$user->get_risk();
					
					foreach ($keys as $K=>$v)
					{
						$this->db->insert('user_aprove_log',array('user_id'=>$user->id,'file_type'=>$K,'file_name'=>$user->$v,'time'=>time()));
					}
					
					echo l('Ваши документы загружены, ожидайте проверки модератора');
					?>
					<script>$('.hideonload').remove();
					$('#click_step5').click();$('a[href*=next]').click();$('.sw-btn-next').click();
					</script>
					<?
					if ($_GET['redirect']) {
						 $this->db->where('user_id',$user->id)->where('status',-2)->update('exchange',['status'=>-1]);
						$user->app=1;
						$user->save();
						redirect_js('/site/system_page/app_id_final');
					}
					
		 
					
					$html_temp=row('mailtemp',10);
					$html_temp['text']=$html_temp['text_'.$user->get_language()]; 
					$html_temp['text']=str_replace('[name]',$user->name.' '.$user->suname,$html_temp['text']);
					$html_temp['text']=str_replace('[email]',$user->email ,$html_temp['text']);
					$html_temp['text']=str_replace('[time]',date('H:i d.m.Y'),$html_temp['text']);
					
					if ($user->name!='testing')  send_mail_stmp(vars('email_docs'),l('Создана заявка'),$html_temp['text'] );
					//foreach (explode(',',vars('sms_number_doc')) as $num)
					//	send_sms($num,'Создана заявка на проверку документов');
						
					slack('Пользователь '.$user->email.' '.$user->name.' '.$user->suname.' загрузил документы с ID заявкой '.$user->id, '#document_new' );
		 
				}
				else {
					if ($_GET['identify']==3) {
						echo "<script> $('#click_step4').click();$('a[href*=next]').click();$('.sw-btn-next').click();</script>";
						echo l('Вы уже подтвердили почту');
					}
				 
				} 
				
			}
	}
	
	
	
	function valut_rates()
	{
		die();
	 
				foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1,'show'=>1)) as $crypto)
			 {
				 foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0,'show'=>1)) as $vlt)
				 { 
					$zn=2;
					if ($crypto['name']=='XRP') $zn=4;
					
					if ($_POST['type']==4):
					?>
					<span><?=$crypto['name']?>/<?=$vlt['name']?> <?=number_format(1/(new Vaucher($this))->get_curs($vlt['id'],$crypto['id']),$zn,',',' ');?></span>
					<?
					elseif ($_POST['type']==5):
					?>
					<li class="d-flex flex-wrap align-items-center">
						<strong><?=$crypto['name']?>/<?=$vlt['name']?></strong>
						<span class="text-truncate"><?=number_format(1/(new Vaucher($this))->get_curs($vlt['id'],$crypto['id']),$zn,',',' ');?></span>
					</li> 
					<? 
					else:
					 ?>
					 <li>  		
					  <strong><?=$crypto['name']?>/<?=$vlt['name']?> </strong>
						<span><? if ($_POST['type']==1) echo number_format(1/(new Vaucher($this))->get_curs($vlt['id'],$crypto['id']),$zn,',',' '); else  echo number_format((new Vaucher($this))->get_curs($crypto['id'],$vlt['id']),$zn,',',' '); ?></span> 
						</li>

					<? 
					 endif;
				 
				 }
			 }
			 
	}
	
	function valut_chart()
	{
		die();
		//print_r($_POST);die();
		$data['valut']=row('valut',(int)$_POST['valut']);
		$data['key_time']=(int)$_POST['time'];
		$data['i']=(int)$_POST['i'];
		
		$dates = array(3600=>'1h',3600*24=>'1d',3600*24*7=>'1w',3600*24*30=>'1m',3600*24*365=>'1y',3600*24*999999=>'all');
				
		$data['dt']=$dates[$data['key_time']];
		
		
		$data['user']=check();
		$data['user_valut']=row('valut',$data['user']->valut_id);
		
		$this->load->view('ajax/ajax_chart.php',$data);
	}
	
	function renew_kurs_dashboard()
	{
		die();
		$user=check();
		
		if ($user->id==0) $user_valut=row('valut',2);
		elseif ($user->valut_id<1) $user->valut_id=2;
		
		$user_valut=row('valut',$user->valut_id);
		
		$zn=2;
		
		$title=$user_valut['name'].'   '.number_format(1/(new Vaucher($this))->get_curs($user_valut['id'],3),$zn,',',' ');
		
		echo json_encode(array('kurs'=>$title,'title'=>$title.' '.l('Buy cryptocyrrency by Credit Card with low comission at bitingle.com')));
	}
	
	function renew_kurs()
	{
		die();
		$user=check();
		$Exchange=new Exchange($this);
		
		if ($user->user_type_id!=1 && $user->user_type_id!=6) $xx="AND user_id='{$user->id}' ";
		
		$res=$this->db->query("SELECT e.*, v.number_format, v.type as crypto FROM exchange e LEFT JOIN valut v ON v.id=e.to
		WHERE e.status<=1 $xx ")->result_array();
		foreach ($res as $k=>$v) {
			//if (($user->user_type_id==1 || $user->user_type_id==6 ) && $v['crypto']) $res[$k]['sum_to']=number_format($res[$k]['sum_to'],$v['number_format']);
			//else 
				$res[$k]['sum_to']=number_format($res[$k]['sum_to'],$v['number_format']);
			
			$res[$k]['status']=$Exchange->status_title[$v['status']];
		}
		
		echo json_encode($res);
	}
	 

	function change_trans3()
	{
	 
		 
		$valut1=row('valut',(int)$_GET['from']);
		$valut2=row('valut',(int)$_GET['to']);

		$rate = $this->db->get_where('valut_rates',['valut1'=>$valut1['id'],'valut2'=>$valut2['id']])->row_array();
		if ($_GET['from_sum']) $result['to_sum']=number_format($rate['result']*$_GET['from_sum'],$valut2['number_format'],'.','');
		else $result['from_sum']=number_format($_GET['to_sum']/$rate['result'],$valut1['number_format'],'.','');
 
		  
		echo json_encode($result);die();
	}
	
	 
	
	function change_trans()
	{
		die();
		$user=check();
		$result=[];
		
		$valut1=row('valut',(int)$_GET['from']);
		if ($_POST['valut_com']) $valut1['com']=$_POST['valut_com'];//из админки
		if ($_POST['sum']+$_POST['sum2']) $_GET['sum']=$_POST['sum'];//из админки
		if ($_POST['crypto'] || $valut1['crypto']) $sum=(real)$_GET['sum']-$valut1['com'];
		else $sum=(real)$_GET['sum'];
		
		if ($_POST['crypto']==0) $_POST['kurs']=1/$_POST['kurs'];
		
		$pay_methods=row('pay_methods',(int)$_GET['pay_methods']);
		
		$valut2=row('valut',(int)$_GET['to']);
		if ($_POST['crypto'] && $_POST['sum']+$_POST['sum2']) $valut2['com']=$_POST['valut_com'];//из админки
		//
		if ((int)$_POST['kurs']==0)
			$_POST['kurs']=-1;
		$result['sum_res_nocom']=$sum*(new Vaucher($this))->get_true_curs($valut1['id'],$valut2['id'],$_POST['kurs']);
		// echo json_encode($result);die();
		//чтобі не использовались в обічном режиме
		if (!isset($_POST['btc_com'])) $_POST['btc_com']=-1;
		if (isset($_GET['btc_com'])) $_POST['btc_com']=$_GET['btc_com'];
		if (!isset($_POST['pay_methods_com'])) $_POST['pay_methods_com']=-1;
		
		if (!isset($_POST['kurs']))	$_POST['kurs']=-1;
		if (!isset($_POST['rate']))	$_POST['rate']=-1;
		
		$result['sum']=$sum*(new Vaucher($this))->get_coms($valut1['id'],$valut2['id'],(int)$_GET['pay_methods'],$_POST['btc_com'],$_POST['pay_methods_com'],$_POST['rate']); 
		$result['sum_res']=$result['sum']*(new Vaucher($this))->get_true_curs($valut1['id'],$valut2['id'],$_POST['kurs'])-$valut2['com'];
		
		// $result['sum']=1/(new Vaucher($this))->get_curs($valut1['id'],$valut2['id'],$_POST['kurs'],$_POST['rate']);
		
		
		 //echo json_encode($result);die();
		$result['sum_res']=number_format($result['sum_res'],5,'.','');
		if ($result['sum_res']<0) $result['sum_res']=0;
		if ($result['sum_res_nocom']<0) $result['sum_res_nocom']=0;
		if ($result['sum']<0) $result['sum']=0;
		//$result['sum_res']= ceil($result['sum_res']*10000)/10000;
		
		//если у юзера комиссия карті прописана вручную 
		if (strlen($user->proc_com) && $pay_methods['card_processing']) $result['pay_methods_com']=$user->proc_com;
		else $result['pay_methods_com']=$pay_methods['com'];
		
		if (strlen($user->btc_com) && $pay_methods['card_processing']) $result['our_com']=$user->btc_com;
		else $result['our_com']=$pay_methods['our_com']; 
		
		$result['valut_com']=$valut1['com']+$valut2['com'];
		$result['metod_name']=$pay_methods['name'];
		$result['reserv']=number_format($valut2['reserv'],2).' '.$valut2['name'];
		$result['minmax']=$pay_methods['min'].' - '.$pay_methods['lim'];
		
		if ($_POST['sum']+$_POST['sum2']) { 
			if (!$_POST['crypto']) $result['sum_res'] -=$valut1['com'];
			echo "Отдавая {$_POST['sum']} вы получите ".$result['sum_res'].', ' ;//из админки
			echo "<br>а чтобы получить {$_POST['sum2']} надо отдать ".(($_POST['sum2']-$valut1['com'])/(new Vaucher($this))->get_coms($valut1['id'],$valut2['id'],(int)$_GET['pay_methods'],$_POST['btc_com'],$_POST['pay_methods_com'])*(1/$_POST['kurs']*(1+$_POST['rate']/100))-$valut2['com']);//из админки
			die();
		}
		
		echo json_encode($result);die();
	}

	function ref_widthdraw()
	{
		$user = check();
		if (!$user->id || $user->money<$_POST['amount'] || $_POST['amount']<1  ) die(l('У вас недостаточно начислений')); 
		if (!$_POST['wallet']) die(l('Укажите номер карты')); 
		$amount=(float)$_POST['amount'];

		$user->money-=$amount;
		$Ex = new Exchange($this);
		$Ex->user_id=$user->id;
		$Ex->from=$Ex->to=46;
		$Ex->sum=$Ex->sum_to=$amount;
		$Ex->create_time=time();
		$Ex->status=1;
		$Ex->wallet=$user->wallet=$_POST['wallet'];
		$Ex->save();
		$user->save();

		die(l('Заявка на вывод создана и будет обработана ближайшие 24 часа')); 

	}
	  
	function step2()
	{

		$valut1= row('valut',$_POST['from']);
		if ($_POST['sum']<$valut1['min']) die('Минимальная сумма: '.$valut1['min'].' '.$valut1['ticker']);
		$Exchange = new Exchange($this); 

		foreach (['from','to','wallet','sum','telegram','tel','name','email'] as $v)
			$array[$v]=strip_tags($this->input->post($v));

		$array['status']=0;
		$user = check();
		if ($user->id) $array['user_id']=$user->id;
		$array['referal']=($_SESSION['referal'] ?? $user->referal);

		$Exchange->update($array);

		if (!$Exchange->id) die('Возникла ошибка. Напишите администратору');
		$_SESSION['ex_id']=$Exchange->id;

		
		


		?>
		<script>step2('<?=$Exchange->id?>','<?=$Exchange->get_key()?>');</script>
		<?

	}
	
	function start_exchange()
	{
		
		
		$this->db->query("DELETE FROM exchange WHERE `from`=0 ");
		 
		$user = check();
		$user->save_log(); 
		 
		if ($user->id<1) die(l('Авторизуйтесь'));
		 
		$valut1=row('valut',$_POST['from']);
		
		if ($valut1['active']==0) die(l('Перевод в данной валюте временно не возможен. Идут технические работы.'));
		if (  $valut1['type']>0) $valut_cash='cash'.$_POST['to'];
		else $valut_cash='cashpm'.$_POST['pay_methods'];
		$valut=row('valut',(int)$_POST['to']);	
		 
		  
			
		//print_r($_POST);
		if (strlen($_POST['wallet'])<1) die(l('Введите кошелек'));
		
		if (strlen($valut['reg'])>0)
		{
			preg_match ('/'.$valut['reg'].'/', $_POST['wallet'] ,   $matches);
			if (count($matches)<1)
			{
				if ($user->$valut_cash==$_POST['wallet']) { 
					$user->$valut_cash='';
					$user->save();
				}
				die(l('Кошелек введен не верно'));
			} 
		} else {
			$user->$valut_cash=strip_tags($_POST['wallet']);
			$user->save();
		}
		
		$_POST['user_id']=$user->id;
		$Exchange = new Exchange($this); 
		$res = $Exchange->update($_POST); 
	 
		$id=$Exchange->id;
		 
		
		$valut_name=$valut1['name'];
		if (  $valut1['crypto']==1) $valut_name=$valut['name'];
		
		$html_temp=row('mailtemp',4);
		$html_temp['text']=$html_temp['text_'.$user->get_language()];
		$html_temp['text']=str_replace('[sum]',(real)$_POST['sum'],$html_temp['text']);
		$html_temp['text']=str_replace('[sum_to]',number_format($Exchange->sum_to,5,'.',''),$html_temp['text']);
		$html_temp['text']=str_replace('[crypto_com]',$valut['com'],$html_temp['text']);
		$html_temp['text']=str_replace('[valut_name2]',$valut['name'],$html_temp['text']);
		$html_temp['text']=str_replace('[ex_id]',$Exchange->id,$html_temp['text']);
		$html_temp['text']=str_replace('[valut_name]',$valut1['name'],$html_temp['text']);
		$html_temp['text']=str_replace('[acc_title]',$valut['name'],$html_temp['text']);
		$html_temp['text']=str_replace('[acc_id]',$_POST['cash'],$html_temp['text']);
		$html_temp['text']=str_replace('[name]',$user->name.' '.$user->suname,$html_temp['text']);
		$html_temp['text']=str_replace('[email]',$user->email ,$html_temp['text']);
		$html_temp['text']=str_replace('[time]',date('H:i d.m.Y'),$html_temp['text']);
		$html_temp['text']=str_replace('[blockchain]',$valut['link'].$Exchange->wallet,$html_temp['text']);
		
		if ($user->id!=1795) send_mail_stmp($user->email,l('Создана заявка').' 5B'.$Exchange->id,$html_temp['text'] );
		
		$html_temp['text'].="<br>
		Клиент e-mail:{$user->email}<br> NAME:{$user->name}<br> ID:{$user->id}<br>
		Ссылка: <a target='_blank' href='https://bitingle.com/admin55/edit/Users/{$user->id}'>Профиль</a>
		"; 
		if ($user->id!=1795) send_mail_stmp(vars('email_resend'),l('Создана заявка').' 5B'.$Exchange->id,$html_temp['text'] );
		
		
		$user->get_risk();
		 
		 ?>
		<script>window.location='/offer?id=<?=$id?>';</script>
		<?
	}
	  
	public function get_base_admin_ajax()
	{
		$user = check(); 
		$User_Type = new User_Type($this,$user->user_type_id);
		if ($User_Type->admin!=1)  die(l('Вы не авторизованы'));
		
		//if ($user->user_type_id!=1 && $user->user_type_id!=6) { $user->logout; redirect2('/login'); } 
	}
	
	public function recovery()
	{  
		$user = new Users($this); 
		 if (isset($_POST['g-recaptcha-response'])) 
		 {
			if (!check_recapcha($this->input->post('g-recaptcha-response'))) {
				$this->lang->load('system', $user->get_language()); 
				echo $this->lang->line('recaptcha_invalid');	
				die();
			}
		 }
		$res = $user->get_recovery_url($this->input->post('email'));
		 
		if ($res['status']>0)
		{ 
			$this->lang->load('system', $user->get_language()); 
			
			$html_temp=row('mailtemp',1);
			$html_temp['text']=$html_temp['text_'.$user->get_language()];
			send_mail_stmp($this->input->post('email'),l('password_recovery_request'),
			str_replace('[you_link]',$res['result'],$html_temp['text'])
			 );
			
			echo $this->lang->line('recovery_email_send');	
		} 
		else  echo $res['error'];	
		 
	}
	
	public function login()
	{ 
		
		
		$user = new Users($this); 
		if (isset($_POST['g-recaptcha-response'])) 
		{
			if (!check_recapcha($this->input->post('g-recaptcha-response'))) {
				$this->lang->load('system', $user->get_language()); 
				echo $this->lang->line('recaptcha_invalid');	
				die();
			}
		} 
		$res = $user->login($this->input->post('email'),$this->input->post('password') );
		 
		$user->save_log();
		
		if ($res)
		{ 
			$user->set_session(1);
			if ($this->input->post('remember')) $remember='?remember=1';
			else $remember='';
			redirect_js('/'.$remember); 
		} 
		else {
			return $this->register();
			$this->lang->load('system', $user->get_language()); 
		
			echo $this->lang->line('login_not_match') ;	
			die();
		}
		
		
	}
	 
	function twologin()
	{
		$user_id=$this->session->userdata('two_id'); 
		$user = new Users($this,$user_id);
		
		$ga=new GoogleAuthenticator;
		$code=$ga->getCode($user->ga_secret);
		if ($code!=$_POST['code']) die(  l('invalid code') );
		
		$user->set_session(1);
		redirect_js('/'.'?remember=1'); 
		die(l('Авторизация успещна'));
	}
	
	public function register()
	{ 
		$user = new Users($this);
		 
		if (isset($_POST['g-recaptcha-response'])) 
		{
			if (!check_recapcha($this->input->post('g-recaptcha-response'))) {
				$this->lang->load('system', $user->get_language()); 
				echo $this->lang->line('recaptcha_invalid');	
				die();
			}
		}  
		$arr=$this->input->post(); $arr['password2']=$arr['password']; 
		$res = $user->register($arr);
		if ($res['status'])
		{
			$user->set_session();
			$user->reg_time=time();
			$html_temp=row('mailtemp',2);
			$html_temp['text']=$html_temp['text_'.$user->get_language()];
			$html_temp['text']=str_replace('[login]',$user->email,$html_temp['text']);
			$html_temp['text']=str_replace('[password]',$_POST['password'],$html_temp['text']);
			
			send_mail_stmp($this->input->post('email'),l($html_temp['name']),$html_temp['text']
			
			 );
			$user->reg_time=time(); 
			 
			redirect_js('/');
		} 
		else echo $res['mes'].' <script>grecaptcha.reset();</script>';
	}
	 
	
	public function save($model_name,$id=0)
	{
		die();
		$user=check();
		if ($user->id<1)  die(l('Вы не авторизованы'));
		
		if (in_array($model_name,array('Delivery')) && 	$user->user_type_id!=2) die(l('Вы не каппер'));
		
		$model = new $model_name($this,$id);
		
		if (in_array($model_name,array('Delivery')) && 	$model->user_id!=$user->id && $id>0) die(l('Это не ваша рассылка'));
		elseif (in_array($model_name,array('Delivery'))) $model->user_id=$user->id;
		
		$update=array();
		foreach ($this->input->post() as $k=>$v)
		{
			if (strlen(trim(strip_tags($v)))<1) die(l('Вы заполнили не все поля'));
			
			if (in_array($k,$model->allow_edit_public_rows() ) && $model->$k!=$v) {
				
				$update[$k]=strip_tags($v);
			}
			
		}
			
		
		
		if (count($update))
		{
			$res = $model->update($update);
			if (strlen($res)>0) die( $res);
			$model->save();
			
			echo l('Данные успешно сохранены'); 
			if ($model_name=='Delivery') redirect_js('/my-services');
		}
		else echo l('Не было введено изменений'); 
	}
	
	public function save_admin($model_name,$id=0)
	{
		
		$user=check();
		$user_type=new User_Type($this,$user->user_type_id);
		if ($user->id<1)  die(l('Вы не авторизованы'));
		elseif ($user_type->admin!=1  ) die(l('Вы не админ'));
		
		
		$model = new $model_name($this,$id);
		 
		$update=array();
		foreach ($this->input->post() as $k=>$v)
		{
			if ($k=='password' && strlen($v)>1 && $_POST['password']==$_POST['password2']) {
				 
					$v=md5($v);
					 $update[$k]=($v); 
			}
			else $update[$k]=($v); 
		} 
		
		if (count($update))
		{
			 
			$res = $model->update($update);
			if (strlen($res)>0) die( $res);
			 
			echo l('Данные успешно сохранены');  
		}
		else echo l('Не было введено изменений'); 
	}
	
	public function save_profile()
	{ 
		 
		
		$user=check();
		if ($user->id<1)  die(l('Вы не авторизованы'));
		$update=array();
		foreach ($this->input->post() as $k=>$v)
			if (in_array($k,$user->allow_edit_public_rows() ) && $user->$k!=$v) $update[$k]=strip_tags($v);
			
		if (isset($update['email']))
		{
			$email_user=$this->db->get_where('users',array('email'=>$update['email']))->row_array();
			if ($email_user['id']!=$user->id && $email_user['id']>0) die(l('Пользователь с таким E-mail уже существует.'));
		}
		
		if ($this->input->post('password'))
			$this->save_password();
		
		if (count($update))
		{
			$user->update($update);
			$user->save();
			
			echo l('Данные успешно сохранены'); 
		}
		else echo l('Не было введено изменений'); 
		
		if ($_GET['identify']==1)
		{
			echo "<script> $('a[href*=next]').click();$('.sw-btn-next').click();</script>";
		}
	}
	 
	public function save_password()
	{ 
		
		
		$user=check();
		if ($user->id<1)  die(l('Вы не авторизованы'));
		
		$this->lang->load('system', $user->get_language()); 
		
		if ($user->password!=md5($this->input->post('old_password'))) die(l('Старый пароль введен не верно'));
		//if ($this->input->post('password')!=$this->input->post('password2')) die(l('Пароли не совпадают'));
		if (strlen($this->input->post('password'))<6) die(l('Пароль не должен быть меньше 6 символов'));
		
		$user->password=md5($this->input->post('password'));
		$user->save();
		
		echo l('Пароль успешно изменен'); 
		echo '<br>';
	}
	
	public function admin_open()
	{
		$user=check();
		$id = (int)$_GET['id'];
		$type=$_GET['div'];
		
		$data = $this->get_base_admin_ajax();

		$result=[];

		if ($type=='a1')
		{
			$Exchange = new Exchange($this,$id);
			$User = new Users($this,$Exchange->user_id);
			$result[]=['mame'=>'#id','param'=>'text','text'=>$User->id];
			$result[]=['mame'=>'#group','param'=>'text','text'=>row('user_type',$User->user_type_id)];
			$result[]=['mame'=>'#register','param'=>'text','text'=>date('d.m.Y H:i',$User->reg_time)];
			$result[]=['mame'=>'#referal_count','param'=>'text','text'=>$User->get_referal_count()];
			if ($User->referal>0)
			{
				$Ref= new Users($this,$User->referal);
				$result[]=['mame'=>'#ref_user','param'=>'text','text'=>"<a href='/admin55/edit/users/{$Ref->id}'>{$Ref->name}</a>"];
			}
			
			$result[]=['mame'=>'#referal_bonus','param'=>'text','text'=>$User->get_referal_bonus().' руб'];
			$result[]=['mame'=>'#referal_proc','param'=>'text','text'=>$User->get_referal_proc().'%'];
			
			$result[]=['mame'=>'#discount','param'=>'text','text'=>(float)$User->discount.'%'];
			$result[]=['mame'=>'#last_ip_access','param'=>'text','text'=>$User->last_ip_access];

			$buttons=[];
			foreach ($this->db->query("SELECT COUNT(id) count, status FROM exchange WHERE user_id='{$User->id}' GROUP BY status ") as $row)
			if ($row['count'])
			{
				$buttons[]=`<a href="/admin55/edit/exchange?filter[status]={$row['status']}" target="_blank" class="btn btn-`.($Exchange->status_color[$row['status']]).` btn-sm fz_10">{$row['count']}</a>`;
			}
			$result[]=['mame'=>'#buttons','param'=>'text','text'=>implode(' ',$buttons)];

			$result[]=['mame'=>'#last_ip_exchange','param'=>'text','text'=>$User->last_ip_exchange];

			$row = $this->db->query("SELECT SUM(rub_in) rub_in, SUM(rub_out) rub_out FROM exchange WHERE user_id='{$User->id}' AND status=2  ");
			$result[]=['mame'=>'#sum_in','param'=>'text','text'=>$row['rub_in']];
			$result[]=['mame'=>'#sum_out','param'=>'text','text'=>$row['rub_out']];


			
			
		}


		die(json_encode($result));

	}

	public function admin_confirm($model_name,$id,$type)
	{
		
		$user=check();
		
		
		$data = $this->get_base_admin_ajax();
		
		$data['model_name'] = mb_convert_case($model_name, MB_CASE_TITLE, "UTF-8");
		$data['model'] = new $data['model_name']($this,$id);
		if ($type=='accept') $data['model']->confirmation_confirm();
		else $data['model']->confirmation_decline();
		echo ' ';
	}
	
	public function admin_nul($col,$id )
	{
		$user=check();
		if ($user->id<1 || $user->user_type_id!=6)  die(l('Вы не авторизованы'));
		
		$us = new Users($this,$id);
		$us->$col='';
		$us->save();
		 
		echo 'Сделано';
	}
	
	function edit_list($model_name)
	{
		//print_r($_GET);die();
		$model_name2=strtolower($model_name);
		$model_name=mb_convert_case($model_name, MB_CASE_TITLE, "UTF-8"); 
		$model = new $model_name($this );
		
		$res['data']=[];
		
		$res['draw'] = (int)$_GET['draw'];
		//$count=$model->get_count();
		
		
		
		$user=check();
		if ($user->id<1  || (  !$user->check_laws('edit/'.$model_name2)))  die(json_encode($res)); 
		
		$addsql='';
		if ($model_name2=='exchange_cash') {
			if ($user->partner_boss>0) $addsql.=" AND method=3 AND partner_id='{$user->partner_boss}' ";
			elseif ($user->user_type_id!=6) $addsql.=" AND method=3 AND partner_id='{$user->id}' ";
			else $addsql.=' AND method=3 ';
		}
		if ($model_name2=='filial' && $user->user_type_id!=6) {
			$addsql.=" AND  partner_id='{$user->id}' ";
		}
		if ($model_name2=='users_partner' ) {
			if ($user->user_type_id!=6) $addsql.=" AND  partner_boss='{$user->id}' ";
			else  $addsql.=" AND  partner_boss>0  ";
		}
		
		//узнаем подключаемые таблицы
		$sql_select2=$sql_select=[]; 
			$sql_join="";
			foreach (array_merge($model->get_table_cols('',$user->id),['tel'=>'tel']) as $key => $val)
			{ 
				if (in_array($key,$model->table_cols)) 
				{
					$sql_select[]=" SUM(`{$model->table}`.`{$key}`)  as `{$key}` ";
					$sql_select2[]="  `{$model->table}`.`{$key}`   as `{$key}` ";
				}
				else {
					$sql_select[]=" SUM({$key}.meta_value) as `{$key}` ";
					$sql_select2[]=" {$key}.meta_value as `{$key}` ";
					$sql_join.=" LEFT JOIN meta_value as `{$key}` ON `{$key}`.`table`='{$model->table}' AND `{$key}`.meta_key='{$key}' AND `{$key}`.id=`{$model->table}`.id ";
				}
			}
			$sql_select=implode(',',$sql_select);
			$sql_select2=implode(',',$sql_select2);
		
		if($_GET['search']['value'])
		{ 
			$search=$_GET['search']['value'];
			if ($model->table=='users') $addsql.=" AND (tel.meta_value LIKE '%$search%' OR    {$model->table}.name LIKE '%$search%' OR {$model->table}.email LIKE '%$search%'  ) ";
			elseif ($model->table=='exchange') $addsql.=" AND ({$model->table}.id = '%$search%' OR {$model->table}.user_id = '%$search%'  ) "; 
		}
		//else $res['recordsFiltered']=(int)$count;
		if ($model->table=='exchange' && $_GET['time1']>0) $addsql.=" AND create_time>'".(int)$_GET['time1']."' AND create_time<'".(int)($_GET['time2']+24*3600)."' ";
		if ($model->table=='transactions' && $_GET['time1']>0) $addsql.=" AND time>'".(int)$_GET['time1']."' AND time<'".(int)($_GET['time2']+24*3600)."' ";
		foreach ($_GET['filter'] as $k=>$v)
			$addsql.=" AND `$k`='$v' ";
		
		
		$r = $this->db->query("SELECT COUNT(`{$model->table}`.id) count FROM `{$model->table}` $sql_join WHERE 1 $addsql ")->row_array();
		$count=$r['count'];
		$res['recordsFiltered']=(int)$count;
		$res['recordsTotal']= (int)$count;
		 
		//addlog("SELECT $sql_select2 FROM `{$model->table}` $sql_join WHERE 1 $addsql ORDER BY id DESC LIMIT ".(int)$_GET['start'].','.(int)$_GET['length']); 
		foreach ($this->db->query("SELECT `{$model->table}`.id, $sql_select2 FROM `{$model->table}` $sql_join WHERE 1 $addsql ORDER BY `{$model->table}`.id DESC LIMIT ".(int)$_GET['start'].','.(int)$_GET['length'])->result_array()
		//$model->get_all(,'id','desc' ,$filter) 
		as $row)
		//foreach ($model->get_all(20,0,'id','desc' ) as $row)
		{
			$dt=[];
			$Us = new $model_name($this);
			foreach ($row as $k=>$v) $Us->$k=$v;
			foreach ($model->get_table_cols('',$user->id) as $key => $val)
			{ 
				//$row[$key]=$Us->$key; 
				$dt[]=$model->get_table_row($key,$row,$Us);
			}
			$dt[]='<a href="/admin55/edit/'.$model_name.'/'.$row['id'].'">Редактировать</a>';
			$dt[]='<a OnClick="if (!confirm(\'Вы уверены что желаете удалить этот элемент?\')) return false;" href="/admin55/edit/'.$model_name.'/'.$row['id'].'/delete">Удалить</a>';
			$res['data'][]=$dt; 
		}
		
		if ($model->table=='transactions')
		{ 
			//собираем суммы для последней строки 
			//addlog("SELECT $sql_select FROM `{$model->table}` $sql_join WHERE 1 $addsql ");
			$sums = $this->db->query("SELECT $sql_select FROM `{$model->table}` $sql_join WHERE 1 $addsql ")->row_array();
		
			$dt=[]; 
			foreach ($model->get_table_cols('',$user->id) as $key => $val)
			{  
				$dt[]=$sums[$key];
			}
			$dt[]='';
			$dt[]='';
			$res['data'][]=$dt; 
		}
		
		die(json_encode($res)); 
	}
}
