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
	
	public function title()
	{
		return 'Шаблоны';
	}

	public function get_table_row($key,$row=array())
	{
		if (count($row)<1) $row=$this->properties;
		$template = $this->get_table_cols_template();
		if (strpos($template[$key],'select_')!==false) { 
			$table = row(substr($template[$key],7),$row[$key]);
			return $table['value'];
		}
		elseif ($key=='value' )
		{ 
			return '
			<label class="custom_checkbox  etc_checkbox">
										<input type="checkbox"  '.(!$row['lock'] ? 'checked=checked' : ' ').' OnClick="ajax(\'template_link_checkbox\',\'id='.$row['id'].'\',\'1\');"  name="checkbox">
										<em class="marker"></em>
										<span class="label fz_12">'.$row[$key].'</span>
									</label> '; 
		}
		elseif (isset($template[$key])) return str_replace('[val]',$row[$key],$template[$key]);
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
		
		 $this->save();
 
	}

	function get_parent_names($id)
	{
		if ($id==0 ) return '';

		$temp = row('template',$id);
		
		
		$str = $temp['value'].' > ';
		
		if ($temp['parent_id']>0 && $temp['parent_id']!=$temp['id']) return $this->get_parent_names($temp['parent_id']).$str;

		return $str;
	}
	 
	public function generate_form_rows($class='',$rows='',$placeholder='',$rows_select='',$req=0 )
	{
		if (!is_array($rows)) $rows=array(  'value'=>'text', 'title'=>'text' );
		if (!is_array($placeholder)) $placeholder=array( 'type'=>'Параметр','title'=>'Русское название','value'=>'Значение','parent_id'=>'Родитель', 'lock'=>'Кастомная ссылка');
		$form=array();
		foreach ($rows as $k=>$v) {
			if ($k=='value'  ) $this->set_js_event('OnChange',"set_result_link();");
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k],$req);
			$form[$k]['title']=$placeholder[$k];
		}
		//со справочниками 
		$types=$this->types;
		$template=[0=>'Пустой родитель'];

		//if ($this->id>0 && $this->type==)
		//if ($this->id) $this->db->where('','');
		$list = $this->CI->db->get('template')->result_array();
		foreach ($list as $row) $template[$row['id']]= $row['value'];
		if (!is_array($rows_select)) $rows_select=array( 'type'=>$types,  'parent_id'=>$template  , 'lock'=>[1=>'Закрытое поле',0=>'Свободное поле'] );
	 
		foreach ($rows_select as $k=>$v) {
			if ($k=='type') $this->set_js_event('OnChange',"select('template_parent',this.value,'#form_parent_id"."');");
			if ($k=='type' || $k=='parent_id' ) $this->set_js_event('OnChange',"set_result_link();");
			$form[$k]['form']=$this->generate_form($k,'select',($k=='parent_id_autocomplete' ? 'autocomplete' : $class),$v,$placeholder[$k],$req); 
			// было autocomplete, ет времена отключили
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