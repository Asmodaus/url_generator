<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Log extends BaseRow
{
	 
	 
	public function get_table_cols()
	{
		return array('time'=>'Время ','timestamp'=>'timestamp ','text'=>'Название' 	); 
	} 
	  
	public function get_table_cols_template()
	{
		return array(  ); 
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
			else return str_replace('[val]',$row[$key],$template[$key]);
		}
		elseif ($key=='time') return date('d.m.Y H:i',$row[$key]); 
		elseif ($key=='timestamp') return $row['time'];
		
		return $row[$key];
	}
	
	 
	
	public function update($array)
	{ 
		 
		
		$this->save();
	}
	
	public function get_log($type='user_balance')
	{
		 $filter=array();
		  
		 if (isset($_GET['time1']))
		 {
			
			 $this->CI->db->where('time >=',strtotime($_GET['time1']));
			  $this->CI->db->where('time <=',strtotime($_GET['time2'])+24*3600);
			 return $this->CI->db->get('log' )->result_array();
		 }
			 
			return $this->CI->db->get('log')->result_array();  
	}
	 
	public function generate_form_rows($class='')
	{
		 
		
		return $form;
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'log',$id); 
	} 
	
	
}