<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class User_Log extends BaseRow
{
	 
	 
	public function get_table_cols()
	{
		return array('timestamp'=>'timestamp ','user_id'=>'Логин ','time'=>'Вход ','logout'=>'Выход ' 	); 
	} 
	  
	public function get_table_cols_template()
	{
		return array( 'user_id'=>'select_users' ); 
	} 
	
	public function title()
	{
		return 'Лог пользователей';
	}
	
	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (isset($template[$key])) {
			if (strpos($template[$key],'select_')!==false) { 
				$table = row(substr($template[$key],7),$row[$key]);
				return '<a href="/admin55/edit/users/'.$row[$key].'">'.$table['name'].'</a>';
			} 
			else return str_replace('[val]',$row[$key],$template[$key]);
		}
		elseif ($key=='time' || $key=='logout') return date('d.m.Y H:i',$row[$key]); 
		elseif ($key=='timestamp') return $row['time'];
		
		return $row[$key];
	}
	
	 
	
	public function update($array)
	{ 
		 
		 
	}
	 
	 
	public function generate_form_rows($class='')
	{
		 
		
		return [];
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'user_log',$id); 
	} 

	
	
	public function allow_edit()
	{
		return false;
	}
	
}