<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function get_base_data()
	{
		$user = check(); 
		if ($user->id>0) date_default_timezone_set($user->timezone);
		$this->lang->load('site', $user->get_language()); 
		 
		if ($_GET['logout'])
		{
			$user = check(); 
			$user->logout();
			redirect2('/');
		}
		//реферальность 
		if ($_GET['referal']>0) 
		{
			$this->session->set_userdata('referal', (int)$_GET['referal']);
			$Ref = new Users($this,(int)$_GET['referal']);
			$Ref->ref_stat_click+=1;
			$Ref->save();
		}
		  
		return array(
		'path'=>'/application/views/site/' 
		,'system_js'=>'<script src="/js/system_js.js?v='.time().'"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script src="/js/exchange.js?v='.time().'"></script>
		'
		,'user'=>$user
		  
		,'need_login'=>array('profile','referals','ex_list','partner' )
		 
		,'title'=>vars('title'),'description'=>vars('description'),'keywords'=>vars('keywords')
		,'not_login'=>array('login','register','recovery')
		,'langs'=>get_all_array((new Language($this))->get_all(50,0,'url','asc',array('active'=>1)),'name','url')
		);
	}
	
	public function logout(){
		//print_r($_SESSION);
		$user = check(); 
		$user->logout();
		//print_r($_SESSION);die();
		redirect2('/?logout=1');
	}
	
	public function index()
	{
		if ($_SESSION['ex_id']==$_GET['cancel'] && $_GET['cancel']) (new Exchange($this,$_SESSION['ex_id']))->delete();
		$data=$this->get_base_data();
		$data['valuts']=$this->db->query("SELECT v.*, r.result rate FROM valut v LEFT JOIN valut_rates r ON r.valut1=v.id AND r.valut2=46 WHERE v.active=1 ")->result_array();
		foreach ($data['valuts'] as &$valut)
			$valut['rate']=($valut['rate']==0 ? 1 : ($valut['rate']<1 ? 1/$valut['rate'] : $valut['rate']));

		$data['faqs']=$this->db->get_where('post',['parent'=>1])->result_array();
		$data['reviews']=$this->db->get_where('post',['parent'=>3])->result_array();
		$data['news']=$this->db->get_where('post',['parent'=>4])->result_array();
	  	$this->load->view('site/index.php',$data);
	}

	
	public function set_hook()
	{
		
		 $telegram_bot=$this->config->item('telegram_bot');
		$res=file_get_contents('https://api.telegram.org/bot'.$telegram_bot.'/setWebhook?url=https://'.$_SERVER['HTTP_HOST'].'/bot/telegram');
		 //die('https://api.telegram.org/bot'.$telegram_bot.'/setWebhook?url=https://'.$_SERVER['HTTP_HOST'].'/bot/telegram');
		die($res);
		
	}
	

	
	

	public function exchange($id,$key)
	{
		$Exchange = new Exchange($this,$id);
		if ($key!=$Exchange->get_key()) redirect('/');
		$data=$this->get_base_data();
		if ($Exchange->status==0 && $_GET['payed']==1) 
		{
			$api_key=$this->config->item('telegram_api');
			$chat_id=vars('chat_id');
			if ($api_key && $chat_id)
			{
				$Telegram = new Telegram($api_key);
				$content = array('chat_id' => $chat_id,  'text' =>'Создана новая заявка на обмен и отмечена как оплаченая. http://'.$this->config->item('domain').'/admin55/edit/exchange/'.$Exchange->id  ); 
				$Telegram->sendMessage($content);
			}
			
			$Exchange->status=1;
			$Exchange->save();
		}
		$data['Exchange']=$Exchange;
		$data['Valut1']=new Valut($this,$Exchange->from);
		$data['Valut2']=new Valut($this,$Exchange->to);
		$data['title']=l('Заявка на обмен #').$Exchange->id;

		$this->load->view('site/exchange.php',$data);
	}
	
	public function recovery($id,$code)
	{
		$data=$this->get_base_data();
		$user = new Users($this);
		$result = $user->recovery_password($id,$code);
		if ($result['status'])
		{
			$this->lang->load('system', $user->get_language());   
			send_mail2($result['email'],$this->lang->line('password_recovery_success'),
			str_replace('[new_password]',$result['password'],$this->lang->line('password_recovery_email_text'))
			,vars('email'));
			
			$data['text']=$this->lang->line('password_recovery_success');
			$this->load->view('site/info.php',$data); 
		}
		else {
			//код не верен
			$data['text']=$result['error'];
			$this->load->view('site/info.php',$data); 
		}
	}
	
	public function pdf_exchange($id)
	{
		$data=$this->get_base_data();
		
		$data['ex']=row('exchange',(int)$id);
		
		$UT = new User_Type($this,$data['user']->user_type_id);
			
		if ($data['ex']['user_id']!=$data['user']->id && $UT->admin!=1  ) redirect('/');
		$data['Exchange'] = new Exchange($this,$data['ex']['id']); 
			 
		
		 
		$data['Exchange']->get_pdf();
	}
	
	
	public function system_page($page,$id=0,$id2=0,$id3=0)
	{
		$data=$this->get_base_data();
		 
		//переадресация со страниц требующих авторизацию и наоборт
		if ($data['user']->id>0 && in_array($page,$data['not_login'])) redirect2('/');
		elseif ($data['user']->id==0 && in_array($page,$data['need_login']))   redirect2('/login');   
		//получнеие доп.данных для определенных страниц
		if ($page=='register') $data['user_types']=(new User_Type($this))->get_all(10,0,'id','asc',array('allow_register'=>1));
		 
		elseif ($page=='profile') {
			$user=$data['user'];
			$data['exchange_count']=$this->db->query("SELECT COUNT(*) count FROM exchange WHERE user_id='{$user->id}' ")->row_array()['count'];  
			$data['referal_count']=$user->get_referal_count();  
			 
			$data['referal_exchange_count']=$user->get_referal_exchange_count(); 
			$data['referal_bonus']=$user->get_referal_bonus(); 
			$data['withdraw']=$this->db->query("SELECT e.* FROM exchange e   WHERE user_id='{$user->id}' AND `from`=`to` AND `from`=46 AND status>0 ")->result_array(); 
		}
	  
		elseif ($page=='ex_res' || $page=='ex_app') 
		{
			if (isset($_POST['order_id'])) $_GET['id']=(int)$_POST['order_id'];
			$data['ex']=row('exchange',(int)$_GET['id']);
			
			//if ($data['ex']['user_id']!=$data['user']->id && $page=='ex_res') redirect('/');
			$data['Exchange'] = new Exchange($this,$data['ex']['id']);
			if ($data['Exchange']->app) $page='ex_app';
			
			if (strlen($_GET['processing'])>0)
			{
				$data['Exchange']->processing=$_GET['processing'];
				$proc='proc_'.$data['Exchange']->processing;
				
				if ($data['user']->$proc>0) $data['Exchange']->method=$data['user']->$proc;
				else $data['Exchange']->method=2;
				$data['Exchange']->calc();
				
				//die($data['Exchange']->pay_method.'='.$proc);
				
				$data['ex']=row('exchange',(int)$_GET['id']);
			//	die('--'.$data['Exchange']->processing);
				//die($data['ex']['method'].'='.$proc);
			}
			 
			if ($_GET['payed']>0 && $data['ex']['status']==0 && ($data['ex']['method']==1 || $data['ex']['method']==12) ) {
				$data['ex']['status']=1;
				$data['Exchange']->status=1;
				$data['Exchange']->save();
				
				
			}
			if ($_GET['cancel']>0 && $data['ex']['status']==0) {
				$data['ex']['status']=3;
				$data['Exchange']->status=3;
				$data['Exchange']->save();
				 
				if ($data['Exchange']->app)
				{
					redirect('/sessions/'.$data['Exchange']->id);
				}
				else 
				{
					$user = $data['user'];
					$pay_methods=row('pay_methods',$data['Exchange']->method); 
					$valut1=row('valut',$data['Exchange']->from);
					$valut2=row('valut',$data['Exchange']->to);
					$valut_name=$valut1['name'];
					if (  $valut1['crypto']==1) $valut_name=$valut2['name'];
					
					$html_temp=row('mailtemp',5);
					$html_temp['text']=$html_temp['text_'.$user->get_language()];
					$html_temp['text']=str_replace('[pay_methods]',$pay_methods['name'],$html_temp['text']);
					$html_temp['text']=str_replace('[sum]',$data['Exchange']->sum,$html_temp['text']);
					$html_temp['text']=str_replace('[sum_com]',$data['Exchange']->sum_com,$html_temp['text']);
					$html_temp['text']=str_replace('[comision]',$data['Exchange']->sum*0.05,$html_temp['text']);
					$html_temp['text']=str_replace('[valut_name]',$valut_name,$html_temp['text']);
					$html_temp['text']=str_replace('[acc_title]',$valut1['name'],$html_temp['text']);
					$html_temp['text']=str_replace('[acc_id]',$data['Exchange']->cach,$html_temp['text']);
					$html_temp['text']=str_replace('[name]',$user->name.' '.$user->suname,$html_temp['text']);
					$html_temp['text']=str_replace('[email]',$user->email ,$html_temp['text']);
					$html_temp['text']=str_replace('[time]',date('H:i d.m.Y'),$html_temp['text']);
					$html_temp['text']=str_replace('[crypto_com]',$valut2['com'],$html_temp['text']);
					$html_temp['text']=str_replace('[valut_name2]',$valut2['name'],$html_temp['text']);
					$html_temp['text']=str_replace('[sum_to]',number_format($data['Exchange']->sum_to,5,'.',''),$html_temp['text']);
					
					send_mail_stmp($user->email,l($html_temp['name']),$html_temp['text'] );
				}
				
					 
			}
			elseif ($_GET['card'] && $data['ex']['status']==0)
			{
				/*
				$baseUrl = $this->config->item('trustpay_url');
				$AID = $this->config->item('trustpay_id');
				$AMT = number_format($data['Exchange']->sum,2,'.','');
				$CUR = "EUR";
				$REF = $data['Exchange']->id;
				$CTY = 1;
						
				$secretKey =  $this->config->item('trustpay_secretKey');
				$sigData = sprintf("%d%s%s%s", $AID, $AMT, $CUR, $REF);
				$SIG = GetSignature($secretKey, $sigData);

				$url = sprintf(
					"%s?AID=%d&AMT=%s&CUR=%s&REF=%s&SIG=%s&CTY=%d", 
					$baseUrl, $AID, $AMT, $CUR, urlencode($REF), $SIG, $CTY);
				header("Location: $url");
				exit();
				*/
			}
			$data['valut1']=row('valut',$data['ex']['from']);
			$data['valut2']=row('valut',$data['ex']['to']);
			
			if ($data['Exchange']->order_id>0 && !$data['Exchange']->app)
			{
				$page='pay_from_api2';
				 
			}
			
		}
		elseif ($page=='ex_list') 
		{
			$data['st'] = (int)$_GET['st'];
			$data['limit'] = 1000;
			$_GET['type']=(int)$_GET['type'];
			if ($_GET['type']==0) $filter=''; 
			elseif ($_GET['type']==1) $filter=' AND status<=1 ';
			elseif ($_GET['type']==2) $filter=' AND status>1 ';
			
			$all_count = $this->db->query("SELECT COUNT(id) count FROM exchange WHERE user_id='{$data['user']->id}' $filter ")->row_array();
			$data['all_count']=$all_count['count'];
			$data['min']=$data['st']-$data['limit']*3;
			if ($data['min']<0) $data['min']=0;
			$data['max']=$data['st']+$data['limit']*3;
			if ($data['max']>$data['all_count']) $data['max']=$data['all_count'];
			
			 
			$data['trans']=$this->db->query("SELECT * FROM exchange WHERE user_id='{$data['user']->id}' AND `from`!=`to` $filter ORDER BY create_time DESC LIMIT {$data['st']}, {$data['limit']} ")->result_array();;
		}
		 
			 
		//закончили получение доп данных
		
		if (isset($_SERVER['HTTP_REFERER'])) $_SESSION['last_page']=$_SERVER['HTTP_REFERER'];//для переадерсации после авторизации 
		
		
		if (!file_exists('.'.$data['path'].$page.'.php')) redirect2('/404');
		else $this->load->view('site/'.$page.'.php',$data); 
	}
	
	public function pay($system,$id=0)
	{
		if ($system=='decta_webhook'  )
		{  
			$body = @file_get_contents('php://input');
			addlog('decta_webhook body:'.($body)); 
		}
		  
		 
		elseif($system=='accentpay')
		{

			$this->db->insert('test',['string'=>time()]);
						
		}
		
		
		 
		elseif ($system=='trustpay')
		{
	 
			addlog(json_encode($_REQUEST));
			 
			$Exchange = new Exchange($this,(int)$_GET['REF']);
			
			if ($Exchange->app  )
			{
				redirect('/ex_app?id='.$Exchange->id);
			}  
			else redirect('/offer?id='.$Exchange->id);
		 
		}
		 

		elseif ($system=='paysera')
		{
			$WebToPay = new Webtopay();
			
			$response = $WebToPay->checkResponse($_GET, array(
				'projectid'     => 100377,
				'sign_password' => 'd8bc5c8da5d7b391e11ab6e14b1df1e5',
			));
		 
			if ($response['test'] !== '0') {
				die('Testing, real payment was not made');
			}
			if ($response['type'] !== 'macro') {
				die('Only macro payment callbacks are accepted');
			}
			addlog(json_encode($response));
			$orderId = $response['orderid'];
			$amount = $response['amount'];
			$currency = $response['currency'];
			
			$User = new Users($this,$response['personcode']);
			if ($currency=='EUR') $User->eur+=$amount;
			if ($currency=='USD') $User->balance+=$amount;
			$User->save();
			 
			echo 'OK';
		}
		else redirect('/');
	}
	
	public function ulogin()
	{
		//авторизация через соц сети
		$result = (new Ulogin)->request($this->input->post('token'));
		$user = new Users($this);
		$user->ulogin($result);
		 
		redirect('/');
	}
	
	public function success()
	{
		$id=(int)$_GET['id']-1000000;
		
		$Exchange = new Exchange($this,$id);
	 
		addlog('pay success partner_id'.json_encode($_GET));
		if ($Exchange->partner_id>0)
		{
			$Us = new Users($this,$Exchange->partner_id);
			addlog('pay success api_url_success'.$Us->api_url_success);
			if (strlen($Us->api_url_success)) redirect($Us->api_url_success);  
		}
		 
		redirect('/ex_res?id='.$id);
	}
	 
	public function defaultt($page,$page2='')
	{
		 
		$page=urldecode($page);
		$data=$this->get_base_data(); 
		$user= check();
		//Турнир?
		 
		
		//Статья
	
		$post = $this->db->get_where('post',array('url'=>mb_strtolower($page,'utf-8'),'language'=>$user->get_language_id()))->row_array();
		if ($post['id']<1) $post= $this->db->get_where('post',array('url'=>mb_strtolower($page,'utf-8') ))->row_array();
		if ($post['id']>0)
		{
			$pagin_start= isset($_GET['st']) ? $_GET['st'] : 0;
			//$data['pagination_count']=vars('pagination_count');
			//$data['pagin_start']=$pagin_start;
			$data['Post']=new Post($this,$post['id']); // $data['pagination_count'],(int)$pagin_start
			$data['postes']=$data['Post']->get_all(999,0,'time','desc',array('parent'=>$data['Post']->id,'language'=>$data['user']->get_language_id()));
			$data['count_post']=$data['Post']->get_count_posts();
			$data['title']=$data['Post']->title;
			$data['description']=$data['Post']->description;
			$data['keywords']=$data['Post']->keywords;
			
			$this->load->view('site/post.php',$data);
			return;
			
		}
		elseif ($page!='404') redirect2('/404');
	}
	
	public function excel($type=1, $date1=0,$date2=9999999999)
	{
		$User = check();
		// Создаем объект класса PHPExcel
			$xls = new PHPExcel();
			// Устанавливаем индекс активного листа
			$xls->setActiveSheetIndex(0);
			// Получаем активный лист
			$sheet = $xls->getActiveSheet();
			if ($type==1)
			{
				if (isset($_GET['date1'])) $date1=strtotime($_GET['date1']);
				if (isset($_GET['date2'])) $date2=strtotime($_GET['date2']);
				
				// Подписываем лист
				$sheet->setTitle(l('Отчет'));
				 $i=1;
				$sheet->setCellValueByColumnAndRow(0 , $i , l('ID'));
					$sheet->setCellValueByColumnAndRow(1 , $i , l('pay_method') );
					$sheet->setCellValueByColumnAndRow(2 , $i , l('sum'));
					//$sheet->setCellValueByColumnAndRow(3 , $i , $valut1['name']);
					$sheet->setCellValueByColumnAndRow(4 , $i , l('с комиссией'));
					//$sheet->setCellValueByColumnAndRow(5 , $i , $valut1['name']);
					$sheet->setCellValueByColumnAndRow(6 , $i , l('получите'));
					//$sheet->setCellValueByColumnAndRow(7 , $i , $valut2['name']);
					
				
				foreach ($this->db->query("SELECT * FROM exchange WHERE user_id='{$User->id}'
					AND create_time>='".(int)($date1)."' AND create_time<='".(int)($date2)."'  ")->result_array() as $row)
				{
					 
					$valut1=row('valut',$row['from']);
					$valut2=row('valut',$row['to']);
					$pay_methods=row('pay_methods',$row['method']);
					
					$i++;
					$sheet->setCellValueByColumnAndRow(0 , $i , $row['id']);
					$sheet->setCellValueByColumnAndRow(1 , $i , $pay_methods['name']);
					$sheet->setCellValueByColumnAndRow(2 , $i , $row['sum']);
					$sheet->setCellValueByColumnAndRow(3 , $i , $valut1['name']);
					$sheet->setCellValueByColumnAndRow(4 , $i , $row['sum_com']);
					$sheet->setCellValueByColumnAndRow(5 , $i , $valut1['name']);
					$sheet->setCellValueByColumnAndRow(6 , $i , $row['sum_to']);
					$sheet->setCellValueByColumnAndRow(7 , $i , $valut2['name']);
				}
 
			}
			
			
		// Выводим HTTP-заголовки
		 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
		 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		 header ( "Cache-Control: no-cache, must-revalidate" );
		 header ( "Pragma: no-cache" );
		 header ( "Content-type: application/vnd.ms-excel" );
		 header ( "Content-Disposition: attachment; filename=result.xls" );

		// Выводим содержимое файла
		 $objWriter = new PHPExcel_Writer_Excel5($xls);
		 $objWriter->save('php://output');
	}
	
	public function oauth()
	{
		$adapters=SocialAuthInit(); 
		
		
		
		if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters)) { 
		
			$auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);
			
			if ($auther->authenticate()) { 
			
				//$auther->getSocialPage();
				//$auther->getSex();
				//$auther->getBirthday());
				//$auther->getAvatar(); 
				$user = new Users($this);
				$user->ulogin(array('email'=>$auther->getEmail(),'identity'=>$auther->getSocialId(),'network'=>$auther->getProvider(),'first_name'=>$auther->getName(),'last_name'=>'' ));
				
				
				
				redirect('/');
			}

		}

	}
	 
	 
	
	 

public function get_xml()
 {
  header("Content-Type: text/xml");
  header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0");
  header("Cache-Control: max-age=0");
  header("Pragma: no-cache");

  $com = vars('btc_com');
  ?>
  <rates>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
  <?foreach (
	array_merge((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>0))
		,(new Pay_Methods($this))->get_all(999,0,'id','asc',array('show_xml'=>1,'buy'=>0))
	)
  as $method):?>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):

		if (strlen($method['city'])>0):
	  $citis=explode(',',$method['city']);
		foreach ($citis as $city):
		
	  ?>
			<item>
			<from><?=$method['bestchange']?><?=$valut2['bestchange']?></from>
			<to><?=$valut1['bestchange']?></to>
		  <in>1</in>
		  <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
			<amount><?=$valut1['reserv']?></amount>
		  
		  <minamount>50 <?=$valut2['name']?></minamount>
		  <?if ($method['lim']>0):?>
		  <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
		  <?endif;?>
		  <city><?=$city?></city> 
		  </item>

		  
		  
		<?endforeach;?>
	  <?else:?>
	  <item>
	  <from><?=$method['bestchange']?><?=$valut2['bestchange']?></from>
	  <to><?=$valut1['bestchange']?></to>
	  <in>1</in>
	   <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut1['reserv']?></amount>
	   
	  <minamount>50 <?=$valut2['name']?></minamount>
	  <?if ($method['lim']>0):?>
	  <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
	  <?endif;?> 
	  </item>
	  
	  		  <?php if($method['bestchange'] == 'WIRE' && $valut2['bestchange'] == 'EUR'){$method['bestchange'] = 'SEPA';?>
			<item>
			<from><?=$method['bestchange']?><?=$valut2['bestchange']?></from>
			<to><?=$valut1['bestchange']?></to>
		    <in>1</in>
		    <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
			<amount><?=$valut1['reserv']?></amount>
		    <minamount>50 <?=$valut2['name']?></minamount>
		    <?if ($method['lim']>0):?>
		    <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
		    <?endif;?>
		    
		    </item>
		  <?php } ?>

	  
	<?endif;?> 
  <?endforeach;?>
  <?endforeach;?>
  <?endforeach;?> 
  
<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
  <?foreach (array_merge((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>1))
		,(new Pay_Methods($this))->get_all(999,0,'id','asc',array('show_xml'=>1,'buy'=>1))
	) as $method):?>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):?>
  
	  <?if (strlen($method['city'])>0):
	  $citis=explode(',',$method['city']);
		foreach ($citis as $city):

	  ?>
			<item>
		  <from><?=$valut1['bestchange']?></from>
		  <to><?=$method['bestchange']?><?=$valut2['bestchange']?></to>
		  <in>1</in>
		  <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		 <amount><?=$valut2['reserv']?></amount> 
		  <param>verifying <?if ($method['auto_out']==0):?>, manual<?endif;?></param>  
		  <minamount>50 <?=$valut2['name']?></minamount>
		  <?if ($method['lim']>0):?>
		  <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
		  <?endif;?> 
		  <city><?=$city?></city> 
		  </item>
		  
		<?endforeach;?>
	  <?else:?>
		  <item>
		  <from><?=$valut1['bestchange']?></from>
		  <to><?=$method['bestchange']?><?=$valut2['bestchange']?></to>
		  <in>1</in>
		   <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut2['reserv']?></amount> 
		  <param>verifying <?if ($method['auto_out']==0):?>, manual<?endif;?></param>  
		  <minamount>50 <?=$valut2['name']?></minamount>
		  <?if ($method['lim']>0):?>
		  <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
		  <?endif;?> 
		  </item>
		  
		 <?php if($method['bestchange'] == 'WIRE' && $valut2['bestchange'] == 'EUR'){$method['bestchange'] = 'SEPA';?>
			<item>
			<from><?=$valut1['bestchange']?></from>
			<to><?=$method['bestchange']?><?=$valut2['bestchange']?></to>
		    <in>1</in>
		    <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
			<amount><?=$valut1['reserv']?></amount>
		    <minamount>50 <?=$valut2['name']?></minamount>
		    <?if ($method['lim']>0):?>
		    <maxamount><?=$method['lim']?> <?=$valut2['name']?></maxamount>
		    <?endif;?>
		    <city><?=$city?></city> 
		    </item>
		  <?php } ?>

	  <?endif;?>
  <?endforeach;?>
  <?endforeach;?>
  <?endforeach;?>
  </rates>
  <?
 }
	

public function get_xml_okchanger()
 {
  header("Content-Type: text/xml");
  header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0");
  header("Cache-Control: max-age=0");
  header("Pragma: no-cache");

  $com = vars('btc_com');
  ?>
  <rates>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
  <?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>0)) as $method):?>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):?>
  <item>
  <from><?=$method['bestchange']?><?=$valut2['bestchange']?></from>
  <to><?=$valut1['bestchange']?></to>
  <in>1</in>
   <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut1['reserv']?></amount> 
  <param> <?if ($method['auto_out']==0):?>  manual<?endif;?></param> 
  </item>
  <?endforeach;?>
  <?endforeach;?>
  <?endforeach;?> 
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
  <?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>1)) as $method):?>
  <?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):?>
  <item>
  <from><?=$valut1['bestchange']?></from>
  <to><?=$method['bestchange']?><?=$valut2['bestchange']?></to>
  <in>1</in>
   <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut2['reserv']?></amount>  
  <param> <?if ($method['auto_out']==0):?>  manual<?endif;?></param> 
  </item>
  <?endforeach;?>
  <?endforeach;?>
  <?endforeach;?> 
  </rates>
  <?
 }
	
	public function get_xml_estandards()
	{
		header("Content-Type: text/xml");
		header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Cache-Control: post-check=0,pre-check=0");
		header("Cache-Control: max-age=0");
		header("Pragma: no-cache");

		$com = vars('btc_com');
		?>
		<rates>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
		<?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>0)) as $method):?>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):?>
		<item>
		<from><?=$method['bestchange']?><?=$valut2['bestchange']?></from>
		<to><?=$valut1['bestchange']?></to>
		<in>1</in>
		 <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut1['reserv']?></amount>  
		</item>
		<?endforeach;?>
		<?endforeach;?>
		<?endforeach;?> 
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1):?>
		<?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>1)) as $method):?>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2):?>
		<item>
		<from><?=$valut1['bestchange']?></from>
		<to><?=$method['bestchange']?><?=$valut2['bestchange']?></to>
		<in>1</in>
		 <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut2['reserv']?></amount>   
		</item>
		<?endforeach;?>
		<?endforeach;?>
		<?endforeach;?> 
		</rates>
		<?
	}
	
	public function get_xml_extrachange()
	{
		header("Content-Type: text/xml");
		header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Cache-Control: post-check=0,pre-check=0");
		header("Cache-Control: max-age=0");
		header("Pragma: no-cache");

		$com = vars('btc_com');
		?>
		<rates>
		<exchanger>
			<online>01-07: 10.00-23.00</online>
			<freetime></freetime>
		</exchanger>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1,'extrachange !='=>'')) as $valut1):?>
		<?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>0,'extrachange !='=>'')) as $method):?>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0,'extrachange !='=>'')) as $valut2):?>
		<item>
		<from><?=$method['extrachange']?><?=$valut2['extrachange']?></from>
		<to><?=$valut1['extrachange']?></to>
		<in>1</in>
		 <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut1['reserv']?></amount>  
		<?if ($method['auto_out']==0):?><param>manual</param><?endif;?>
		</item>
		<?endforeach;?>
		<?endforeach;?>
		<?endforeach;?> 
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1,'extrachange !='=>'')) as $valut1):?>
		<?foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>1,'extrachange !='=>'')) as $method):?>
		<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0,'extrachange !='=>'')) as $valut2):?>
		<item>
		<from><?=$valut1['extrachange']?></from>
		<to><?=$method['extrachange']?><?=$valut2['extrachange']?></to>
		<in>1</in>
		 <out><?=(new Vaucher($this))->get_true_curs($valut2['id'],$valut1['id'])*(new Vaucher($this ))->get_coms( $valut2['id'], $valut1['id'], $method['id']);?></out>
		<amount><?=$valut2['reserv']?></amount>  
		<?if ($method['auto_out']==0):?><param>manual</param><?endif;?>
		</item>
		<?endforeach;?>
		<?endforeach;?>
		<?endforeach;?> 
		</rates>
		<?
	}
	
	public function get_xml_json()
	{
		header("Content-Type: text/json");
		
		$result=array();
		
		$com = vars('btc_com');
		
		foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1)
		{
			$from=array();
			foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>0)) as $method)
			{
				foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2)
				{
					$result['exchanges']['from'][$method['bestchange'].$valut2['bestchange']]['to'][$valut1['bestchange']] = array('in'=>10000,'out'=>10000*(real)number_format((new Vaucher($this))->get_curs($valut2['id'],$valut1['id']),6),'amount'=>$valut1['reserv'],"in_fee"=> array('%',(real)$method['our_com']+$method['com']),'options'=>array('manual','identity'));
				}
			}
			
			 
		}
		
			
		foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $valut1)
		{
			$from=array();
			foreach ((new Pay_Methods($this))->get_all(999,0,'id','asc',array('enable'=>1,'buy'=>1)) as $method)
			{
				foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $valut2)
				{
					$result['exchanges']['from'][$valut1['bestchange']]['to'][$method['bestchange'].$valut2['bestchange']] = array('in'=>10,'out'=>10*(real)number_format((new Vaucher($this))->get_curs($valut1['id'],$valut2['id']),6,'.',''),'amount'=>$valut2['reserv'],"in_fee"=> array('%',(real)$method['our_com']+$method['com']),'options'=>array('manual','identity'));
				}
			} 
		}
		 
		echo json_encode($result);
	}
	
	
	function apiappl($p1='',$p2='')
	{
		$data = json_decode(file_get_contents('php://input'), FALSE); 
		addlog($p1.'/'.$p2.'/  '.json_encode($data));
		 
		if ($p1=='currencies' && $p2=='supported')
		{
			$res=[];
			foreach ((new Valut($this))->get_all(99,0,'id','desc',['show'=>1,'crypto'=>0]) as $row) 
				$res['currencies']['payment'][]=['symbol'=>$row['name'], 'type'=>'FIAT'];
			 
			foreach ((new Valut($this))->get_all(99,0,'id','desc',['show'=>1,'crypto'=>1]) as $row) 
				$res['currencies']['target'][]=['symbol'=>$row['name'], 'type'=>'CRYPTO'];
			
			echo json_encode($res);die();
		}
		elseif ($p1=='quotes' && $p2=='')
		{
			$headers = apache_request_headers(); 
			 
			$row = $this->db->get_where('meta_value',['meta_value'=>$headers['x-auth-client']])->row_array();
			$P = new Users($this,$row['id']);
			
			
			 $data = json_decode(file_get_contents('php://input'), true); 
			$from = $this->db->get_where('valut',['name'=>$data['currency']['payment']['symbol']])->row_array();
			$to = $this->db->get_where('valut',['name'=>$data['currency']['target']['symbol']])->row_array();
			$curs =  1/(new Vaucher($this))->get_curs($from['id'],$to['id'])*(1+$P->app_com/100) ;
			addlog($curs  );
			$pay_method = row('pay_methods',2);
			
			if($curs>0  )
			{
				$res=[];
				$res['quote_id']=$from['id'].'0'.$to['id'];
				$res['valid_until']=time()+60;
				$res['quote']=[
					'payment'=>['symbol'=>$from['name'],'type'=>$data['currency']['payment']['type']],
					'target'=>['symbol'=>$to['name'],'type'=>$data['currency']['target']['type'] ],
					'rate'=>$curs,
					'min_to_buy'=>$pay_method['min'],
					'max_to_buy'=>$pay_method['lim']
				];
				addlog(json_encode($res));
			}
			else {
				$res['error']='No available quotes';
			}
			
			echo json_encode($res); 
		}
		   
		elseif ($p1=='buy_crypto' )
		{
			if ($data->api_key!=vars('api_key') )
			{
				$res['error']='Failed!';
			}
			else {
				$from = $this->db->get_where('valut',['name'=>$data->from])->row_array();
				$to = $this->db->get_where('valut',['name'=>$data->to])->row_array();
				
				$Exchange = new Exchange($this); 
				$arr['user_id']=1780;
				$arr['cash']=$data->cash;
				$arr['sum']=$data->sum;
				$arr['to']=$to['id'];
				$arr['from']=$from['id'];
				$arr['pay_methods']=16;
				
				$res = $Exchange->update($arr);  
				$pay_methods=row('pay_methods',16);
				
				$res['status']='success';
				$res['ex_id']=$Exchange->id; 
				$res['sum_netto']=$Exchange->sum_com; 
				$res['com']=$pay_methods['com']; 
				$res['transcoin_com']=$pay_methods['our_com']; 
				if ($from['crypto'])  $res['valut_com']=$from['com']; 
				if ($to['crypto'])  $res['valut_com']=$to['com']; 
				$res['crypto_sum']=$Exchange->sum_to; 
			}
			
			
			echo json_encode($res); 	
		}
	}
	 
	
}
