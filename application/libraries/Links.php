<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Links    extends BaseRow
{
	public function get_table_cols()
	{
		return array('id'=>'ID','source'=>'Источник','time'=>'Время','url'=>'Ссылка','short_url'=>'Короткая ссылка','text'=>'Комментарий'); 
	} 

	
	public function show_filters()
	{
		return ['source' ];
	}
	
	
	public function get_table_cols_template()
	{
		return array('img'=>'<img src="/upload/[val]" width="50" >'); 
	} 
	
	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (isset($template[$key])) return str_replace('[val]',$row[$key],$template[$key]);
		elseif ($key=='time' ) return date('d.m.Y H:i',$row[$key]); 
		return $row[$key];
	}
	
	public function update($array)
	{
		return false;
	}
	 
	public function generate_form_rows($class='')
	{
		return [];
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'links',$id); 
	} 
	
	
	public function allow_edit()
	{
		return false;
	}
}