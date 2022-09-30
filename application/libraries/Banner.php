<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Banner extends BaseRow
{
	 
	public function get_table_cols($type)
	{
		 return array('id'=>'ID','name'=>'Название', 'img'=>'Изображение'  ,'lang'=>'Язык'	); 
	} 
	 
	 
	public function get_table_cols_template()
	{
		return array('img'=>'<img src="/upload/[val]" width="50" >','lang'=>'select_language'); 
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
		 
				//тут добавим сохранение времени и файла
		if (count($_FILES))
		{ 
			foreach ($_FILES as $k=>$v)
			{
				$file_name = $this->img_upload($k,'./upload/country/');
				if (!is_array($file_name)) $array[$k]='country/'.$file_name;  
				else $result[]=$file_name['error'];
			}
                 
		}
		//обычное сохранение
		foreach ($array as $k=>$v) 
			 $this->$k=$v;  
		
		$this->save();
	}
	 
	 
	public function generate_form_rows($class='')
	{
		//простые поля  
		$rows=array('name'=>'text' ,'img'=>'file_img' );
		$placeholder=array('name'=>'Название','img'=>'Баннер', 'lang'=>'Язык' );
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками
		 
		$select_array=array( 'lang'=>'language'		);
		foreach ($select_array as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,'select',$class,$v ,$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		 
		
		
		return $form;
	} 
	 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'banner',$id); 
	} 
	
	
}