<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Users extends BaseRow
{
	private $laws='';
	
	public function get_table_cols($type='base')
	{
	 
		   
		return array( 'name'=>'Имя','email'=>'E-mail'  ,  'user_type_id'=>'Тип пользователя'  ,'text'=>'Комментарий' 
		,'link'=>'Кастомная ссылка'  ,'log'=>'Лог' 
			// ,'country_id'=>'Страна','ip_country'=>'ИП Страны' ,'ip_city'=>'ИП Города'
		); 
	} 
	  
	
	public function save_log()
	{
		$row = $this->CI->db->query("SELECT * FROM user_log WHERE user_id='{$this->id}' ORDER BY id DESC")->row_array();
		//последние данные взяли
		$Browser = new Browser();
		$Browser->Browser();
		$browser=$Browser->getBrowser();
		
		$ip=get_ip();
		$ips=explode(',',$ip);
		$ip=$ips[0];
		
		$ref = $_SESSION['HTTP_REFERER'];
		 
		if ($row['ip']!=$ip || $row['browser']!=$browser)
		{
			
			$this->CI->db->insert('user_log',array('browser'=>$browser,'ip'=>$ip,'ref'=>$ref,'time'=>time(),'user_id'=>$this->id));
		}
	}
	 
	public function generate_form_rows($class='',$rows='',$placeholder='',$rows_select='',$req=0 )
	{
		//простые поля  
		if (!is_array($rows)) $rows=array(  'name'=>'text', 'email'=>'text', 'text'=>'text'  ,'password'=>'text'
	 
			);
		if (!is_array($placeholder)) $placeholder=array( 
		'name'=>'Имя','email'=>'E-mail', 'user_type_id'=>'Тип пользователя' , 'text'=>'Комментарий','link'=>'Кастомная ссылка'
		);
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k],$req);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками 
	 
		if (!is_array($rows_select)) $rows_select=array(   'user_type_id'=>'user_type' ,'link'=>[0=>'Запрещено',1=>'Разрешено']  );
		$US = check();
		if ($US->user_type_id!=6) unset($rows_select['user_type_id']);
		foreach ($rows_select as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,'select',$class,$v,$placeholder[$k],$req);
			$form[$k]['title']=$placeholder[$k];
		}
		 
		
		return $form;
	} 
	
	public function check_laws($page)
	{
		if ($this->id<1) return false;
		if ($this->user_type_id==6) return true;
		if (!is_array($this->laws)) 
		{
			$this->laws=array();
			$res = $this->CI->db->get_where('admin_law',array('user_id'=>$this->id))->result_array();
			$res3 = $this->CI->db->get_where('admin_type_law',array('user_type_id'=>$this->user_type_id))->result_array();
			$res2 = $this->CI->db->get_where('admin_pages')->result_array();
			foreach ($res2 as $row) $admin_pages[$row['id']]=$row['url']; 
			foreach ($res as $row) $this->laws[]=$admin_pages[$row['admin_pages_id']];
			foreach ($res3 as $row) $this->laws[]=$admin_pages[$row['admin_pages_id']];
		}
		if (in_array($page,$this->laws)) return true;
		return false;
	}
	
	public function allow_edit_public_rows()
	{
		return  array('address','telegram' ,'tel','name_ico_tkn','app_com','doc_end','lang_page_pay','price_token','tkn_cur','tkn_cur2','logo_p','api_url_success','api_url_decline','api_url_post','name','timezone','suname','city','street', 'pay_methods', 'zip' ,'dic_id1','dic_id2','doc','country_id','valut_id','timezone' );
	}
	 
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'users',$id); 
		
		if ($id>0)
		{
			if (strlen($this->timezone)>0)
			{
				date_default_timezone_set($this->timezone);
			}
		}
	} 
	
	public function get_table_cols_template()
	{
		return array( 'user_type_id'=>'select_user_type','date_enter_doc'=>'time','reg_time'=>'time','doc_end'=>'time', 'time'=>'time','user'=>'select_users','country_id'=>'select_country'
		
		,'detalis'=>'<a target="_blank" href="/admin55/detalis/users/[id]">Детали</a>'
		,'opt_graph_balance'=>'<a target="_blank" href="/admin55/graph/user_balance/[id]">Посмотреть график</a>','opt_logs'=>'<a target="_blank" href="/admin/logs/[id]/user_balance">Транзакции</a>'); 
	} 
	
	public function get_table_row($key,$row=array(), Users $Us  )
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if ($key=='link')
		{ 
			return ($row[$key] ? 'Да' : 'Нет');
		}
		 
		if ($key=='log')
		{ 
			return '<a href="/admin55/edit/log?filter[user_id]='.$row['id'].'">Лог</a>';
		}
		if ($key=='tel')
		{ 
			return $Us->tel_prefix.$Us->tel;
		}
		if ($key=='user_email')
		{ 
			if ($Us->partner_id>0)
				return  $Us->email;
			return $Us->email;
		}
	  
		if ($key=='nul_tel')
		{ 	if (strlen($Us->tel)==0) return 'Не подтвержден';
			else return "<a href='javascript:' id='tel{$row['id']}' OnClick=\"ajax('admin_nul/tel/{$row['id']}','','#tel{$row['id']}');\" >Обнулить</a>";
		}
		if ($key=='nul_two')
		{ 
			if ($Us->twofactor!='yes') return 'Не включена';
			else return "<a href='javascript:' id='twofactor{$row['id']}' OnClick=\"ajax('admin_nul/twofactor/{$row['id']}','','#twofactor{$row['id']}');\" >Отключить</a>";
		}
		
		if ($key=='photo')
		{ 
			$adddoc='<p><a href="#" OnClick="$(\'#passport_doc\').attr(\'src\',\'/upload/'.$Us->passport2.'\');$(\'#passport_doc_load\').attr(\'href\',\'/upload/'.$Us->passport2.'\');" class="cat__core__link--underlined mr-2" data-toggle="modal" data-target="#photopass"><i class="icmn-eye"><!-- --></i> Оборотная сторона ID</a></p>';
			 if (strlen($Us->passport2)==0)	$adddoc='';
			return '
			<p><a href="#" OnClick="$(\'#passport_doc\').attr(\'src\',\'/upload/'.$Us->passport.'\');$(\'#passport_doc_load\').attr(\'href\',\'/upload/'.$Us->passport.'\');" class="cat__core__link--underlined mr-2" data-toggle="modal" data-target="#photopass"><i class="icmn-eye"><!-- --></i> Паспорт или ID</a></p>
            '.$adddoc.'
            
			<p><a href="javascript: void(0);" OnClick="$(\'#bank_doc\').attr(\'src\',\'/upload/'.$Us->bank.'\');$(\'#bank_doc_load\').attr(\'href\',\'/upload/'.$Us->bank.'\');" class="cat__core__link--underlined mr-2" data-toggle="modal" data-target="#photoutility"><i class="icmn-eye"><!-- --></i> Фото</a></p>           
            <p><a href="javascript: void(0);" OnClick="$(\'#bank_doc\').attr(\'src\',\'/upload/'.$Us->adresdoc.'\');$(\'#bank_doc_load\').attr(\'href\',\'/upload/'.$Us->adresdoc.'\');" class="cat__core__link--underlined mr-2" data-toggle="modal" data-target="#photoutility"><i class="icmn-eye"><!-- --></i> Подтверждение адреса</a></p>           
                  
			';
		}
		if ($key=='name')
		{
			
			return ' <a href="javascript: void(0);" class="cat__core__link--underlined">'.$row[$key].'</a>';
		}
		if ($key=='email')
		{ 
			if ($Us->partner_id>0)
				return '<a href="javascript: void(0);" class="cat__core__link--underlined"> '.$Us->email.'</a>';
			return '<a href="/admin55/edit/Users/'.$row['id'].'" class="cat__core__link--underlined">'.$row[$key].'</a>';
		}
		
		if (isset($template[$key])) $template[$key]=str_replace('[id]',$row['id'],$template[$key]);
		
		if (isset($template[$key])) {
			if (strpos($template[$key],'select_')!==false) { 
				$table = row(substr($template[$key],7),$row[$key]);
				return $table['name'];
			}
			elseif ($template[$key]=='time') return date('d.m.Y H:i',$row[$key]);
			elseif ($template[$key]=='date') return date('d.m.Y',$row[$key]);
			elseif (isset($row[$key])) return str_replace('[val]',$row[$key],$template[$key]);//возвращаем шаблон со значением
			else return $template[$key];//возвращаем шаблон без значения
		}
		
		
		
		return $row[$key];
	}
	
	public function check_cookie()
	{
		$row = $this->CI->db->get_where('users',array('id'=>get_cookie('user_id')))->row_array();
		if (md5($row['password'].$row['email'])==get_cookie('hash'))
		{
			$this->construct($this->CI,'users',$row['id']); 
			$this->set_session();
			return true;
		}
		return false;	
	}
	
	
	public function logout()
	{
		foreach ($_SESSION as $K=>$V) unset($_SESSION[$K]);
		$this->CI->session->unset_userdata('user_id');
		$this->CI->input->set_cookie('user_id', '', 0, base_domain() , '/' );
		$this->CI->input->set_cookie('hash','', 0, base_domain() , '/' );
		
		
		//print_r($_COOCKIE);die();
	}
	
	
	
	public function set_session($remember=0)
	{
		$this->CI->session->set_userdata('user_id', $this->id);
		if ($remember)
		{ 
			$this->CI->input->set_cookie('user_id', $this->id, 30*24*3600, base_domain() , '/' );
			$this->CI->input->set_cookie('hash', md5($this->password.$this->email), 30*24*3600, base_domain() , '/' ); 
		}
	}
	
	public function login($login,$password,$remember=0)
	{ 
		$row = $this->CI->db->get_where('users',array('email'=>$this->CI->db->escape_str($login),'password'=>md5($password)))->row_array();
		
		if ($row['id']>0  )
		{
			$row = $this->CI->db->get_where('users',array('email'=>$this->CI->db->escape_str($login)  ))->row_array();
		
			$this->construct($this->CI,'users',$row['id']); 
			//if ($this->twofactor=='yes') return 2;
			//else 
			$this->set_session($remember);
			return true;
		}
		return false;
	}
	
	public function ulogin($params)
	{
		
		 
		 
		if (isset($params['email']) && strlen($params['email'])>0)
			$row = $this->CI->db->get_where('users',array('email'=>$params['email']))->row_array();
		
		
		
		if (!isset($row['id'])  )
			$row = $this->CI->db->get_where('users',array('network_id'=>$params['identity'],'network'=>$params['network']))->row_array();
		if ($row['id']>0)
		{
			$this->construct($this->CI,'users',$row['id']); 
			$this->set_session();
			return true;
		}
		$this->network_id=$params['identity'];
		$this->network=$params['network'];
		if (isset($params['email'])) $this->email=$params['email']; else $this->email=$params['network'].$params['identity'];
		$p = explode(' ',$params['first_name']);
		$params['last_name']=$p[1];
		$params['first_name']=$p[0];
		$this->name=$params['first_name'];
		$this->suname=$params['last_name'];
		$this->password=$params['network'].$params['identity']; 
		$this->reg_time=time();
		$this->save();
		$this->set_session();
		return true;
	}
	
	public function get_recovery_url($login)
	{ 
		
		$row = $this->CI->db->get_where('users',array('email'=>$this->CI->db->escape_str($login)))->row_array();
		if ($row['id']>0)
		{
			return array('status'=>true,'result'=>URI_PROTOCOL.$_SERVER['HTTP_HOST'].'/site/recovery/'.$row['id'].'/'.md5($row['password'].$row['email'])); 
		} 
		$this->CI->lang->load('system', $this->get_language()); 
		return array('status'=>false,'error'=> $this->CI->lang->line('email_not_valid'));	
	}
	
	public function recovery_password($user_id,$code)
	{ 
		$row = row('users', $user_id);
		if ($row['id']>0)
		{
			if (md5($row['password'].$row['email'])==$code)
			{
				$this->construct($this->CI,'users',$row['id']); 
				$password=rand(100000,99999999999);
				$this->password=md5($password);
				$this->save();
				return array('status'=>true,'password'=>$password,'email'=>$row['email']);
			} 
		} 
		$this->CI->lang->load('system', $this->get_language());  
		return array('status'=>false,'error'=>$this->CI->lang->line('code_not_valid'));
	}
 
	
	public function register($array)
	{ 
		$this->CI->load->helper('email');
		$this->CI->lang->load('system', $this->get_language()); 
		$err='';
		//print_r($array);die();
		if (!isset($array['user_type_id'])) $array['user_type_id']=4;
		else {
			$user_type = row('user_type',$array['user_type_id']);
			if ($user_type['allow_register']!=1) $array['user_type_id']=4;
		} 
		unset($array['id']);
		unset($array['balance']);
		unset($array['g-recaptcha-response']);
		
		
		$row = $this->CI->db->get_where('users',array('email'=>$this->CI->db->escape_str($array['email']) ))->row_array();
		if ($row['id']>0) $err=$this->CI->lang->line('email_exists'); 
		 
		 
		
		if (strlen($array['password'])<6) $err=$this->CI->lang->line('password_short'); 
		if ($array['password']!=$array['password2'] && isset($array['password2'])) $err=$this->CI->lang->line('password2not_match');  
		if (strlen($array['email'])<3 || !valid_email($array['email']) ) $err=$this->CI->lang->line('email_not_valid');  
		
		unset($array['password2']);
		$array['password']=md5($array['password']);
		
		
		$referal= $this->CI->session->userdata('referal'); 
	 
		if ($referal>0) $this->referal=$referal;
		
		if (strlen($err)<1)
		{
			if ($array['timezone']>0) $array['timezone']='+'.(int)$array['timezone'];
			$array['timezone']='Etc/GMT'.$array['timezone'];
			$this->update($array);
			$this->reg_time=time();
			return array('status'=>true,'mes'=>$this->CI->lang->line('register_succes'));
		} 
		return array('status'=>false,'mes'=>$err);
	}
	
	public function update($array,$declineiferror=0)
	{ 
		if ($this->ban==0 && $array['ban']==1)
		{
			if ($this->ban_text=='') $this->ban_text='None';
			send_mail_stmp($this->email,l('Вы были заблокированы'),l('Вы были заблокированы по причине:').$this->ban_text);
		}
		 
		 
		if (count($_FILES))
		{ 
			foreach ($_FILES as $k=>$v)
			if ($v['size']>0)
			{
				$file_name = $this->img_upload($k,'./upload/participant/');
				 
				if (!is_array($file_name)) $array[$k]='participant/'.$file_name;  
				else { $result[]=$file_name['error'];
					if ($declineiferror)
					{
						$this->decline_text=l('Некорректный файл. Загрузите другой');
						$this->save();
						die();
					}
				}
			} 
		}
		//обычное сохранение
		foreach ($array as $k=>$v) {
			if (is_array($v)) {
				if (isset($v['date']) && isset($v['time'])) $this->$k=strtotime($v['date'].' '.$v['time']);
				//die($this->$k.' '.$k.' '.time());
			}  
			else $this->$k=$v; 
			 
			
		}
		
		 
		$this->save();
		
		
	}
	
	public function set_balance($val,$comment='')
	{ 
		$change=$val-$this->balance;
		if ($change!=0)$this->CI->db->insert('user_balance',array('user'=>$this->id,'time'=>time(),'balance'=>$val,'change_balance'=>$change,'comment'=>$comment));
		
		return $this->balance=$val;
	}
	
	public function get_language_id()
	{
		$language=$this->get_language();
		$row = $this->CI->db->get_where('language',array('name'=>$language))->row_array();
		return (int)$row['id'];
	}
	
	public function get_url_language2($return_row=false)
	{
		$host=explode('.',$_SERVER['HTTP_HOST']);
		if (count($host)>=3) {
			return $lang_uri=$host[0];
			 
		}
		
		return 'en'; 
	}
	
	public function get_url_language($return_row=false)
	{
		$cur_us = check();
		if (strlen($this->language)>0 && $cur_us->id!=$this->id && !isset($_GET['setlang'])) return $this->language;
		
		$host=explode('.',$_SERVER['HTTP_HOST']);
		if (count($host)>=3) {
			$lang_uri=$host[0];
			$row = $this->CI->db->get_where('language',array('url'=>$lang_uri,'active'=>1))->row_array();
			if (isset($row['id'])) {
				if ($this->id>0) {
					$this->language=$row['name'];$this->save();
				}
				return $row['name'];
			}
		}
		//if (strlen($this->language)>0) return $this->language;
		if ($this->id>0) {
					$this->language=DEFAULT_LANGUAGE;$this->save();
				}
		return DEFAULT_LANGUAGE; 
	}
	
	public function set_language($language)
	{ 
		$row = $this->CI->db->get_where('language',array('name'=>$language,'active'=>1))->row_array();
		$this->language=$language;
		$this->save();
		if (isset($row['id'])) redirect('//'.$row['url'].base_domain().$_SERVER['REQUEST_URI']); 
	}
	
	public function get_language()
	{
		return $this->get_url_language(); 
		/*
		$domain_lang = $this->get_url_language(); 
		$language = $this->CI->session->userdata('language');
		if (strlen($language)) return $language;
		if (!isset($this->id)) $language = $domain_lang; 
		elseif (isset($this->properties['language']) && strlen($this->properties['language'])>0)  $language = $this->properties['language']; 
		elseif ($this->id>0)
		{ 
			$this->language = $domain_lang; 
			$this->save(); 
			$language = $domain_lang;
		} else $language = $domain_lang;
		
		$this->CI->session->set_userdata('language', $language);
		
		if ($domain_lang!=$language) {
			$row = $this->CI->db->get_where('language',array('name'=>$language))->row_array();
			redirect('//'.$row['url'].base_domain().$_SERVER['REQUEST_URI']);
		}
		
		return $language;
		*/
		
	}
	  
	
	
}