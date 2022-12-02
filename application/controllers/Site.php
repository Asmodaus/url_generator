<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	function get_base_data()
	{
		 
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
		redirect('/admin55/');
	}

	
	public function set_hook()
	{
		
		 $telegram_bot=$this->config->item('telegram_bot');
		$res=file_get_contents('https://api.telegram.org/bot'.$telegram_bot.'/setWebhook?url=https://'.$_SERVER['HTTP_HOST'].'/bot/telegram');
		 //die('https://api.telegram.org/bot'.$telegram_bot.'/setWebhook?url=https://'.$_SERVER['HTTP_HOST'].'/bot/telegram');
		die($res);
		
	}

	public function short_url($url)
	{
		$link = $this->db->get_where('links',['s_url'=>$url])->row_array();
		if ($link['url']) redirect($link['url']);
		else redirect('/');
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
	  
	public function ulogin()
	{
		//авторизация через соц сети
		$result = (new Ulogin)->request($this->input->post('token'));
		$user = new Users($this);
		$user->ulogin($result);
		 
		redirect('/');
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
	 
	 
	
	 
 
	 
	
}
