<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class User_Aprove_Log extends BaseRow
{
	 
	 
	public function get_table_cols($type='base')
	{
		if ($type=='log') 	return array('time'=>'Время ','timestamp'=>'timestamp ','user_id'=>'Пользователь' ,'file_name'=>'Файл','cancel_text'=>'Результат'	); 
		return array('time'=>'Время ','timestamp'=>'timestamp ','user_id'=>'Пользователь','users_ip'=>'IP Адрес','users_country_id'=>'Страна','users_zip'=>'ZIP','users_street'=>'Адрес' ,'file_name'=>'Файл','cancel_text'=>'Результат'	); 
	} 
	  
	public function get_table_cols_template()
	{
		return array( 'time'=>'time' ,'file_name'=>'<a target="_blank" href="/upload/[val]">Посмотреть</a>'); 
	} 
	
	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (isset($template[$key])) {
			if (strpos($template[$key],'select_')!==false) { 
				$table = row(substr($template[$key],7),$row[$key]);
				return $table['name'];
			}
			elseif ($template[$key]=='time') return date('d.m.Y H:i',$row[$key]);
			else return str_replace('[val]',$row[$key],$template[$key]);
		}
		elseif ($key=='timestamp') return $row['time'];
		/*
		elseif (substr($key,0,6)=='users_' )
		{
			$Us=new Users($this->CI,$row['user_id']);
			$k=substr($key,6);
			if (strpos($template[$k],'select_')!==false) { 
				$table = row(substr($template[$k],7),$Us->$k);
				return $table['name'];
			}
			return $Us->$k;
		}*/
		return $row[$key];
	}
	
	 
	
	public function update($array)
	{ 
		 
		
		$this->save();
	}
	
	public function get_log($user_id=0 )
	{
		$this->CI->db->where('user_id',$user_id);
		 if ($_GET['time1'])
		 {
			 $this->CI->db->where('time >',strtotime($_GET['time1']));
			 $this->CI->db->where('time <',strtotime($_GET['time2'])); 
		 }
			 
		return $this->CI->db->get('user_aprove_log' )->result_array();  
	}
	 
	public function generate_form_rows($class='')
	{
		 
		
		return $form;
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'user_aprove_log',$id); 
	} 
	
	
}