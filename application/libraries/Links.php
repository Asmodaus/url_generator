<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require_once './application/libraries/BaseRow.php';

class Links    extends BaseRow
{
	public function get_table_cols()
	{
		return array( 'p0'=>'Источник',
		'p1'=>'utm_medium','p2'=>'utm_campaign','p3'=>'utm_content','p4'=>'utm_term','p5'=>'get'
		,'time'=>'Время','url'=>'Ссылка','text'=>'Комментарий');  //,'short_url'=>'Короткая ссылка'
	} 

	
	public function show_filters()
	{
		return ['p0','p1','p2','p3','p4','p5' ];
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
		elseif (in_array($key,['p0','p1','p2','p3','p4','p5' ]) && is_numeric($row[$key])) 
		{
			$temp = row('template',$row[$key]);
			if ($temp['id']) return $temp['value'];
		} 
		elseif ($key=='time' ) return date('d.m.Y H:i',$row[$key]); 
		return $row[$key];
	}
	
	public function update($array)
	{
		//обычное сохранение
		foreach ($array as $k=>$v) 
		if (is_array($v)) {
			if (isset($v['date']) && isset($v['time'])) $this->$k=$this->get_timestamp($v['date'],$v['time']);
		} 
		elseif ($k=='text') $this->$k=str_replace('\n','',str_replace('\r','',$v));
		else	$this->$k=$v; 

		if (!$this->id) $this->time = time();

		$params=[];
		$Template = new Template($this->CI);
		$templates = get_all_array($Template->get_all(1000),'id','value');
		for ($i=0;$i<=5;$i++)
		{
			$params[]=$Template->types[$i].'='.$templates[$this->{'p'.$i}];
		}
		$this->url = $this->short_url .'?'. implode('&',$params);

		$this->save();

 
	}
	 
	public function generate_form_rows($class='')
	{
		$rows=array(   );
		if (!$this->id)
		{
			$rows['short_url']='text';

		}
		else
		{
			$rows['url']='disabled';
		}
		$rows['text']='text';
		$placeholder=array( 'text'=>'Комментарий','short_url'=>'Ссылка','url'=>'Итоговая ссылка' );
		$form=array();
		foreach ($rows as $k=>$v) {
			$form[$k]['form']=$this->generate_form($k,$v,$class,array(),$placeholder[$k]);
			$form[$k]['title']=$placeholder[$k];
		}

		if (!$this->id)
		{
			//со справочниками 
			$rows_select=[];
			for ($i=0;$i<=5;$i++)
			{
				$cats=[];
				foreach ($this->CI->db->get_where('template',['type'=>$i])->result_array() as $row ) $cats[$row['id']]=$row['value'];
				$rows_select['p'.$i]=$cats;
				$placeholder['p'.$i]=(new Template($this))->types[$i];
				if ($i<5) $script['p'.$i]="select('template',this.value,'#form_p`.($i+1).`');";
			}
			 
		
			foreach ($rows_select as $k=>$v) {
				if (isset($script[$k])) $this->set_js_event('OnChange',$script[$k]);
				$form[$k]['form']=$this->generate_form($k,'select',$class,$v,$placeholder[$k]);
				$form[$k]['title']=$placeholder[$k];
			}
		}
		 
		
		return $form;
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