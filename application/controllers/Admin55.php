<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin55 extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function get_base_data($page='')
	{ 
		date_default_timezone_set('Europe/Moscow');
		
		$user = check(); 
		$user_type = new User_Type($this,$user->user_type_id);
		$admurl="/admin55/";
		//die('-'.$user_type->id);
		if ($user->id<1) { $user->logout();  redirect2('/login'); } 
		elseif ($user_type->admin!=1  ) { $user->logout();  redirect2('/login'); }   
		
		
		if (strlen($page)>0) if (!$user->check_laws($page) && $page!='edit/links') {  die($page); redirect2('/login'); } 

		$filter='';
		foreach ($_GET['filter'] as $k=>$v)
		$filter.="&filter[{$k}]={$v}";


		$editors=array( 
		
		 
		//'materials'=>'Материалы', 
		 'links'=>'Архив ссылок',  
		//   'stats'=>'Статистика',
		   'template'=>'Настройка шаблонов' 
		//	 ,'mailtemp'=>'Шаблоны писем' ,'banner'=>'Баннеры'
		// ,'action'=>'Акции','pay_methods'=>'Методы оплаты'  
			  //  ,'options'=>'Настройки' 
			); 
			
			 
		$editors2=array( 
	//	'blacklist'=>'Блєклист',
	//	 'users_partner'=>'Менеджеры',
		'users'=>'Пользователи','user_type'=>'Уровни пользователей'
		//	'admin_pages'=>'Панели администратора','admin_law'=>'Доступы к админ.панели'
		 
			 ,'user_log'=>'Лог пользователей' //+
			// ,'admin_pages'=>'Админ панели'
			
			 
			);
		//$logs=array('vaucher'=>'Транзакции','log'=>'Логи АПИ','log_kraken'=>'Логи Кракена','log_aprove'=>'Лог апрувов' , 'log_birza'=>'Лог Биржи'  );
	//	$logs=array('log'=>'Логи АПИ','log_pay'=>'Логи Платежки','log_kraken'=>'Логи Кракена','log_aprove'=>'Лог апрувов' );
	//	$graphs=array('vaucher'=>'Частота транзакций' );
		if ($user->user_type_id!=6) { unset($editors['users']); unset($editors['admin_pages']);  unset($editors['admin_law']);}
		 
		
		
		
		return array(
		'path'=>'/application/views/admin/',
		'editors'=>$editors,'editors2'=>$editors2
		,'user'=>$user
		,'filter'=>$filter 
		,'system_js'=>'
		<script src="/js/system_js.js?v='.time().'"></script>
		<script src="/js/cms.js?v='.time().'"></script>
		<script src="/js/editor.js"></script>'
		,'admurl'=>$admurl);
		 
	}
 
	public function detalis($type='',$id='')
	{
		$data=$this->get_base_data(); 
		
		if ($type=='users') $model_name='user_aprove_log';
		else $model_name=$type;
		
		$data['model_name'] =  mb_convert_case($model_name, MB_CASE_TITLE, "UTF-8");
		$data['model'] = new $data['model_name']($this,$id);
		$data['user_id']=$id;
		
		$type=strtolower($type);
		
		if (!file_exists('.'.$data['path'].'detalis_'.$type.'.php')) redirect2('/404');
		else $this->load->view('admin/detalis_'.$type.'.php',$data); 
	}
	
	public function page($page,$id=0,$id2=0,$id3=0)
	{
		$data=$this->get_base_data(); 
		 
		
		
		if (!file_exists('.'.$data['path'].$page.'.php')) redirect2('/404');
		else $this->load->view('admin/'.$page.'.php',$data); 
	}
	  
	
	
	public function index()
	{
		
		$data=$this->get_base_data(); 
		$data['model'] = new Links($this,$_GET['id']);
		$data['p0']=$this->db->get_where('template',['type'=>0])->result_array();
		
		if (count($_POST)) $data['model']->update($_POST); 
	 
		$this->load->view('admin/generator.php',$data);
		
	}
	 
	public function logs($model_name='',$id=0,$log_type='')
	{
		if ($_GET['time1'])
		{
			$data['filter']=array('time >='=>strtotime($_GET['time1']),'time <'=>strtotime($_GET['time2'])+24*3600);
		}
		
		
		$data=$this->get_base_data('logs'); 
		
		if (strlen($model_name)<1) redirect2($data['admurl'].'logs/users'); 
		$data['model_name'] = mb_convert_case($model_name, MB_CASE_TITLE, "UTF-8");
		$data['model'] = new $data['model_name']($this,$id);
		$data['log_type']=$log_type;
		$this->load->view('admin/logs.php',$data); 
	}
	 
	
	public function login()
	{
		$data['path']='/application/views/admin/';
		$this->load->view('admin/login2.php',$data);
	}
	 
	
	public function edit($model_name='',$id=0,$do='')
	{
		global $admin;
		
		if ($model_name=='generator')
		{
			redirect('/admin55/');
		}
		 
		$data=$this->get_base_data('edit/'.strtolower($model_name));
		 
		
		
		if (strlen($model_name)<1) redirect2($data['admurl'].'edit/links'); 
		$data['model_name'] = mb_convert_case($model_name, MB_CASE_TITLE, "UTF-8");
		$data['model'] = new $data['model_name']($this,$id);
		$data['filter']=array();
		
		if ($_GET['time1'])
		{
			$data['filter']=array('time >='=>strtotime($_GET['time1']),'time <'=>strtotime($_GET['time2'])+24*3600);
		}
		if ($_GET['filter'])
		{
			foreach ($_GET['filter'] as $k=>$v)
				if (strlen($v)>0) $data['filter'][$k]=$v;
		}
		
		if ($do=='delete')
		{ 
			$data['model']->delete();
			redirect2($data['admurl'].'edit/'.$model_name); 
		}
		elseif ($id>0 || $do=='add' || $do=='save')
		{ 
			if ($do=='save')
			{
				$admin=1;
				if ($data['model_name']=='Vaucher' && $id==0)
				{
					$count = $_POST['count']; 
					unset($_POST['count']);
					for ($i=1;$i<=$count;$i++)
					{
						$data['model'] = new $data['model_name']($this,$id);
						$data['result'] = $data['model']->update($_POST); 
					}
				}
				else {
					$data['result'] = $data['model']->update($_POST); 
					//print_r($data['result']);die();
				}
			} 
			if ($_GET)
				foreach ($_GET as $k=>$v)
					$data['model']->$k=$v;
			 
			$this->load->view('admin/edit.php',$data);
		}
		else
		{ 
			if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
			if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d');

			if ($data['model_name']=='Links' && $data['user']->user_type_id!=6)
				$data['filter']['user_id']=$data['user']->id;

			$data['p0']=$this->db->get_where('template',['type'=>0])->result_array();
			if ($_GET['param'] && $_GET['value']) $data['filter'][$_GET['param']]=$_GET['value'];
			 
			if ($data['filter']['p0']==0) unset($data['filter']['p0']);

			$data['edit_list']=$data['model']->get_all(2000,0,'id','desc',$data['filter']);
			

			if ($do=='csv')
			{
				$this->export_excel($data);
			}
			
			$this->load->view('admin/'.$data['model']->edit_list(),$data);  
		}
		 
		
	}

	
	public function export_excel($data)
	{
		 
		 
		$xls = new PHPExcel();
			// Устанавливаем индекс активного листа
		$xls->setActiveSheetIndex(0);
			// Получаем активный лист
		$sheet = $xls->getActiveSheet(); 
	 
		 
				// Подписываем лист
				$sheet->setTitle($data['model']->title());
				 $i=0;
				
				$valuts=array();	
				  
				
				$i++;

				foreach ($data['edit_list'] as $row)
				{
					$j=0;
					
					foreach ($data['model']->get_table_cols() as $key => $val)
					{
						if (!isset($row[$key]))
							{ 
								$Us = new $data['model_name']($this,$row['id']);
								foreach ($Us as $k=>$v) $row[$k]=$v; 
							}
						 
						$sheet->setCellValueByColumnAndRow($j , $i ,strip_tags($data['model']->get_table_row($key,$row)));
						$j++;
					} 
					$i++;
				}  
				 
		
		
		 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
			 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
			 header ( "Cache-Control: no-cache, must-revalidate" );
			 header ( "Pragma: no-cache" );
			 header ( "Content-type: application/vnd.ms-excel" );
			 header ( "Content-Disposition: attachment; filename=result.xls" );

			// Выводим содержимое файла
			 $objWriter = new PHPExcel_Writer_Excel5($xls);
			 $objWriter->save('php://output');
			 die();
	}
	
	 
}

