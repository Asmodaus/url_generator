<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	
	function get_base_data()
	{
		return array(
		'path'=>'/application/views/site/' 
		);
	}
	 
	private function get_parent_names($id)
	{
		return (new Template($this))-> get_parent_names($id); 
	}

	function get_parrent_array($id)
	{ 
		if ($id<=0) return ;
		$temp = row('template',$id);
		if ($temp['parent_id']) return array_merge($this->get_parrent_array($temp['parent_id']),[$temp['type']=>$temp['value']]);

		return [$temp['type']=>$temp['value']];

	}

	function set_result_link()
	{
		$parent_id = (int)$_GET['parent_id'];
		$value =  $_GET['value'];
		$type = (int)$_GET['type'];

		$list= $this->get_parrent_array($parent_id);
		$list[$type]=$value;
		$Template = new Template($this);
		$params=[];
		foreach ($list as $k=>$v)
		{
			$params[]=$Template->types[$k].'='.$v;
		}

		echo implode('&',$params);
	}

	function  button_select()
	{
		$user=check();
		if (!$user->id) return false;

		$table = $this->input->get('table');
		if (!in_array($table,['template','template_parent']))  die();

		$val = $this->input->get('val');

		$data['buttons']=[]; 


		if ($table=='template_parent')
		{
			foreach ($this->db->get_where('template',['type'=>$val-1])->result_array() as $row) 
				$data['buttons'][$row['id']]=$this->get_parent_names($row['parent_id']).' '.($row['name'] ?? $row['value']);
		} 
		elseif ($table=='template' && $val!=0)
		{
			$temp = row('template',$val);
			$data['level']=$temp['type']+1;

			foreach ($this->db->get_where($table,['parent_id'=>$val])->result_array() as $row) 
				$data['buttons'][$row['id']]=($row['title'] ? $row['title'] : $row['value']);

			if ($val<0)
			foreach ($this->db->get_where($table,['parent_id'=>0,'type'=>-1*$val-1])->result_array() as $row) 
				$data['buttons'][$row['id']]=($row['title'] ? $row['title'] : $row['value']);

			
			 
		}
			

		$this->load->view('ajax/buttons.php',$data); 
	}

	function  select()
	{
		$user=check();
		if (!$user->id) return false;

		$table = $this->input->get('table');
		if (!in_array($table,['template','template_parent']))  die();

		$val = $this->input->get('val');

		$data['options']=[];
		$data['show_input']=false;


		if ($table=='template_parent')
		{
			foreach ($this->db->order_by('id','desc')->get_where('template',['type'=>$val-1])->result_array() as $row) 
				$data['options'][$row['id']]=$this->get_parent_names($row['parent_id']).' '.($row['name'] ?? $row['value']);
		} 
		elseif ($table=='template' && $val!=0)
		{
			$temp = row('template',$val);


			foreach ($this->db->order_by('id','desc')->get_where($table,['parent_id'=>$val])->result_array() as $row) 
				$data['options'][$row['id']]=($row['value'] ? $row['value'] : $row['value']);

			if ($val<0)
			foreach ($this->db->order_by('id','desc')->get_where($table,['parent_id'=>0,'type'=>-1*$val-1])->result_array() as $row) 
				$data['options'][$row['id']]=($row['value'] ? $row['value'] : $row['value']);

			
			if ($user->link && !$temp['lock']) $data['show_input']=true;
			$data['level']=$temp['type']+1;
		}
			

		$this->load->view('ajax/select_options.php',$data); 
	}
	   
	function user_link_checkbox()
	{
		$this->get_base_admin_ajax();
		$Us = new Users($this,(int)$_POST['id']);
		if ($Us->link) $Us->link=0;
		else $Us->link=1;
		$Us->save();
		return true;
	}

	function link_comment()
	{
		$user=check();

		$T = new Links($this,(int)$_POST['id']);
		if (!$T->id || ($user->id!=$T->user_id && $user->user_type_id!=6)) return false;
		$T->text=$_POST['text'];
		$T->save();
		return true;
	}


	function template_link_checkbox()
	{
		$this->get_base_admin_ajax();
		$T = new Template($this,(int)$_POST['id']);
		if ($T->lock) $T->lock=0;
		else $T->lock=1;
		$T->save();
		return true;
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
		//$Country = new Country($this,$Us->country_id);
		?>
		 <dt class="col-sm-3">Имя</dt>
                        <dd class="col-sm-9"><?=$Us->name?></dd>

                        <dt class="col-sm-3">Фамилия</dt>
                        <dd class="col-sm-9"><?=$Us->suname?></dd>

                        <dt class="col-sm-3">Адрес:</dt>
                        
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
