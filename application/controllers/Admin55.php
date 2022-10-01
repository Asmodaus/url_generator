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
		
		
		if (strlen($page)>0) if (!$user->check_laws($page)) {  die($page); redirect2('/login'); } 

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
		'users'=>'Пользователи','user_type'=>'Уровни пользователей',
			'admin_pages'=>'Панели администратора','admin_law'=>'Доступы к админ.панели'
		 
			 ,'user_log'=>'Лог пользователей' //+
			 ,'admin_pages'=>'Админ панели'
			
			 
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
	//	,'logs'=>$logs
	//	,'graphs'=>$graphs 
		,'system_js'=>'
		<script src="/js/system_js.js"></script>
		<script src="/js/cms.js"></script>
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
	  
	public function export_excel($type='Transactions')
	{
		$data = $this->get_base_data();
		
		$user = check(); 
		if ($user->user_type_id!=1 && $user->user_type_id!=6) { $user->logout; redirect2('/login'); } 
		if (strlen($type)>0) if (!$user->check_laws($type)) {  redirect2($data['admurl'].'index'); } 
		
		$xls = new PHPExcel();
			// Устанавливаем индекс активного листа
		$xls->setActiveSheetIndex(0);
			// Получаем активный лист
		$sheet = $xls->getActiveSheet(); 
		if (isset($_GET['time1'])) $date1=strtotime($_GET['time1']); else $date1=time()-24*3600*30;
		if (isset($_GET['time2'])) $date2=strtotime($_GET['time2'])+24*3600; else $date2=time()+24*3600;
				
		 
				// Подписываем лист
				$sheet->setTitle(l('Транзакции'));
				 $i=0;
				
				$valuts=array();	
				  
				
				$i++;
				 
				$this->db->where('create_time >',$date1);
				$this->db->where('create_time <',$date2);
				foreach ($this->db->get('telegram_exchange')->result()  as $model)
				{
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , date('d.m.Y',$model->create_time));
					$sheet->setCellValueByColumnAndRow(1 , $i ,'Rate, %/ price' );
					$sheet->setCellValueByColumnAndRow(2 , $i , 'BTC, USD');
					$sheet->setCellValueByColumnAndRow(3 , $i , 'BTC, EUR');
					$sheet->setCellValueByColumnAndRow(4 , $i , 'RUB');
					$sheet->setCellValueByColumnAndRow(5 , $i , 'Course'); 
					$sheet->setCellValueByColumnAndRow(6 , $i , 'USD'); 
					$sheet->setCellValueByColumnAndRow(7 , $i , 'Course'); 
					$sheet->setCellValueByColumnAndRow(8 , $i , 'EUR'); 
					
					$sheet->getStyle('A'.$i.':A'.$i)->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'bdd6ee')
							)
						)
					);
					$i++; 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Client trade amount');
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->sum_trade*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_trade,2));
					 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Interest');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->com);
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->sum_eur*$model->kurs_usd_eur*$model->com/100,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_eur*$model->com/100,2));
					 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Client total amount');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->com);
					if ($model->valut==7)    $sheet->setCellValueByColumnAndRow(4 , $i ,number_format($model->sum,2) );
					if ($model->valut==7)  $sheet->setCellValueByColumnAndRow(5 , $i , $model->kurs_rub_usd);
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->sum_eur*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_eur,2));
					$sheet->getStyle('A'.$i.':I'.$i)->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'bdd6ee')
							)
						)
					); 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Trade amount (buy for client)');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->kurs);
					$sheet->setCellValueByColumnAndRow(2 , $i , $model->sum_to); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->sum_trade*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_trade,2));
					$i++; 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Profit/loss:');
					 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Interest Q_BTC');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->q_btc_com); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->sum_eur*$model->kurs_usd_eur*$model->q_btc_com/100,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_eur*$model->q_btc_com/100,2));
					
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Andrej commission');
					if($model->valut==7)	$sheet->setCellValueByColumnAndRow(1 , $i , $model->andrey_com); 
					if($model->valut==7)	$sheet->setCellValueByColumnAndRow(4 , $i , $model->sum/100*$model->andrey_com); 
					if ($model->valut==7)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_rub_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format(-1*$model->andrey_com_eur,2));
					 
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Buy commission');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->buy_com); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format(-1*$model->sum_eur*$model->buy_com/100*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->sum_eur*$model->buy_com/100,2));
					
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Transfer commission');
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->trade_com); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format(-1*$model->sum_eur*$model->trade_com/100*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format(-1*$model->sum_eur*$model->trade_com/100,2));
					$i++;  
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Profit/loss'); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->profit*$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->profit,2));
					  
					$i++; 
					$sheet->setCellValueByColumnAndRow(0 , $i , 'Zhenya commission'); 
					$sheet->setCellValueByColumnAndRow(1 , $i , $model->zhenya_com); 
					if ($model->valut!=2)    $sheet->setCellValueByColumnAndRow(6 , $i ,number_format($model->zhenya_profit *$model->kurs_usd_eur,2) );
					if ($model->valut!=2)  $sheet->setCellValueByColumnAndRow(7 , $i , $model->kurs_usd_eur);
					$sheet->setCellValueByColumnAndRow(8 , $i , number_format($model->zhenya_profit  ,2));
					$sheet->getStyle('A'.$i.':I'.$i)->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'bdd6ee')
							)
						)
					); 
					
					$i++;
					$i++;    
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
	}
	
	
	
	public function index()
	{
		
		$data=$this->get_base_data(); 
		$data['model'] = new Links($this);
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
		 
		
		
		if (strlen($model_name)<1) redirect2($data['admurl'].'edit/country'); 
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
		if ($do=='csv')
		{
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename=result.csv');
			header('Pragma: no-cache');
			header("Expires: 0");
			
			$profit=0;
			
			$outputBuffer = fopen("php://output", 'w');
			
			foreach ($data['model']->get_all(5000,0,'id','desc',$data['filter']) as $row)
			{
				$array=array();
				
				foreach ($data['model']->get_table_cols() as $key => $val)
				{
					if (!isset($row[$key]))
						{ 
							$Us = new $data['model_name']($this,$row['id']);
							foreach ($Us as $k=>$v) $row[$k]=$v; 
						}
					
					$array[]=strip_tags($data['model']->get_table_row($key,$row));
				}
				$profit+=$row['profit'];
				fputcsv($outputBuffer, $array);
			} 
			if ($profit>0)
			{
				fputcsv($outputBuffer, array('Прибыль:',$profit));
			}
			fclose($outputBuffer);
			die();
		}
		if ($id>0 || $do=='add' || $do=='save')
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
			 
			$this->load->view('admin/edit.php',$data);
		}
		else
		{ 
		 
			 
			$this->load->view('admin/'.$data['model']->edit_list(),$data);  
		}
		 
		
	}
	 
}
