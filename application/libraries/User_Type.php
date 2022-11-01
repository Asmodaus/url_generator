<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class User_Type    extends BaseRow
{
	public function get_table_cols()
	{
		return array('name'=>'Название' ); 
	} 
	
	public function get_table_cols_template()
	{
		return array(); 
	} 
	
	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (isset($template[$key])) return str_replace('[val]',$row[$key],$template[$key]);
		return $row[$key];
	}
	
	public function update($array)
	{ 
		$this->properties['admin_pages_id']=[];
		$this->CI->db->where('user_type_id',$this->id)->delete('admin_type_law'); 
		foreach ($array['admin_pages_id'] as $v)
		{
			 $this->properties['admin_pages_id'][$v]=$v;
			 $this->CI->db->insert('admin_type_law',array('user_type_id'=>$this->id,'admin_pages_id'=>$v));
		}
		unset($array['admin_pages_id']);
		
		//обычное сохранение
		foreach ($array as $k=>$v) $this->$k=$v; 
		$this->save();
	}
	 
	public function title()
	{
		return 'Управление ролями';
	}
	
	public function generate_form_rows($class='')
	{
		//простые поля  
		$rows=array('name'=>'text');
		$placeholder=array('name'=>'Название','admin'=>'Доступ в панель','allow_register'=>'Разрешено выбрать при регистрации');
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками
		$rows=array('admin'=>'select'); //'allow_register'=>'select',
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array('1'=>'Да','0'=>'Нет'),$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		
		$rows=array('admin_pages_id'=>'admin_pages'   );
		foreach ($rows as $k=>$v) { 
			$form[$k]['form']=$this->generate_form($k,'checkbox',$class,$v,$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}
		
		return $form;
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'user_type',$id); 
		
		if ($id!=0  )
		{ 
			 
				foreach ($this->CI->db->get_where('admin_type_law',array('user_type_id'=>$id))->result_array() as $v)
				{
					$this->properties['admin_pages_id'][$v['admin_pages_id']]=$v['admin_pages_id'];
				}	 
					 
				
			 
			
		}
	} 
	
	
}