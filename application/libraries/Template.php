<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Template    extends BaseRow
{

	public $types=[0=>'utm_source',1=>'utm_medium',2=>'utm_campaign',3=>'utm_content',4=>'utm_term',5=>'get'];

	public function get_table_cols()
	{
		return array('id'=>'ID','type'=>'Параметр','value'=>'Значение','parent_id'=>'Родитель' ); 
	} 
 
	public function edit_list()
	{
		return 'template.php';
	}
	
	
	public function get_table_cols_template()
	{
		return array('img'=>'<img src="/upload/[val]" width="50" >','parent_id'=>'select_template'); 
	} 
	
	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (isset($template[$key])) return str_replace('[val]',$row[$key],$template[$key]);
		elseif ($key=='time' ) return date('d.m.Y H:i',$row[$key]); 
		elseif ($key=='type') return $this->types[$row[$key]];
		return $row[$key];
	}
	
	public function update($array)
	{

			//обычное сохранение
			foreach ($array as $k=>$v) 
			if (is_array($v)) {
				if (isset($v['date']) && isset($v['time'])) $this->$k=$this->get_timestamp($v['date'],$v['time']);
			} 
			elseif ($k=='url') {
				if (isset($array['language'])) $lang=$array['language'];
				else $lang=$this->language;
				$v=(mb_strtolower($v,'utf-8'));
				$res = $this->CI->db->get_where('post',array('url'=>$v,'language'=>$lang))->row_array();
				
				if ($res['id']!=$this->id && $res['id']>0) $v=$v.rand(100,9999); 
				$this->$k=$v; 
			} 
			//elseif ($k=='text') $this->$k=str_replace('\n','',str_replace('\r','',$v));
			else	$this->$k=$v; 
		
		 

		return true;
	}
	 
	public function generate_form_rows($class='',$rows='',$placeholder='',$rows_select='',$req=0 )
	{
		if (!is_array($rows)) $rows=array(  'value'=>'text' );
		if (!is_array($placeholder)) $placeholder=array( 'type'=>'Параметр','value'=>'Значение','parent_id'=>'Родитель');
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k],$req);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками 
		$types=$this->types;
		$template=[0=>'Без родителя'];

		//if ($this->id>0 && $this->type==)
		//if ($this->id) $this->db->where('','');
		$list = $this->CI->db->get('template')->result_array();
		foreach ($list as $row) $template[$row['id']]=$row['name'];
		if (!is_array($rows_select)) $rows_select=array( 'type'=>$types,  'parent_id'=>$template   );
	 
		foreach ($rows_select as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,'select',$class,$v,$placeholder[$k],$req);
			$form[$k]['title']=$placeholder[$k];
		}
		 
		
		return $form;
	} 
	
	public function __construct($CI,$id=0) 
	{ 
		$this->construct($CI,'template',$id); 
	} 
	
	
	public function allow_edit()
	{
		return false;
	}
}