<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Mailtemp extends BaseRow
{
	public $parent_value=array();
	 
	public function get_table_cols()
	{
		return array('id'=>'ID','name'=>'Название' 		); 
	}  
	
	public function get_table_cols_template()
	{
		return array('url'=>'<a href="/[val]">/[val]</a>','language'=>'select_language'); 
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
	
		
		return $row[$key];
	}
	 
	
	public function update($array)
	{ 
		 
		
		//обычное сохранение
		foreach ($array as $k=>$v) 
			 $this->$k=$v; 
		
		 
		
		$this->save();
	}
	 
	public function generate_form_rows($class='')
	{
		//простые поля  
		$rows=array('name'=>'text',   'text_english'=>'textarea', 'text_russian'=>'textarea', 'text_latvian'=>'textarea','text_Estonian'=>'textarea');
		$placeholder=array('name'=>'Название',   'text_english'=>'HTML Eng', 'text_russian'=>'HTML Rus', 'text_latvian'=>'HTML Latv','text_Estonian'=>'HTML Estonian'
		
		, 'text_Estonian'=>'HTML Estonian'
		);
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками
		 
		
		
		return $form;
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'mailtemp',$id); 
	} 
	
	
}