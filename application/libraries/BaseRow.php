<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class BaseRow  
{
	public $table;	
	public $id=0;
	public $properties = array();
	private $properties2 = array();
	public $CI;
	private $meta_vals = array();
	public $table_cols = array();
	private $loaded=0;
	private $form_add_html;
	 
	public function __construct($CI,$table,$id=0,$url='',$key='') 
	{ 
		$this->construct($CI,$table,$id,$url,$key); 
	} 

	public function allow_edit()
	{
		return true;
	}

	public function show_filters()
	{
		return [];
	}
	
	public function edit_list()
	{
		return 'edit_list.php';
	}

	public function confirmation_list()
	{
		return 'confirmation_list.php';
	}

	public function construct($CI,$table, $id=0,$url='',$key='') 
	{ 
		
		$this->CI=$CI;
		if (isset($CI->CI)) $this->CI=$CI->CI;
		$id=(int)$id;
		$this->table=$this->CI->db->escape_str($table);  
		
		$table_cols = $this->CI->db->query("SHOW COLUMNS FROM `{$this->table}` ")->result_array();
		foreach ($table_cols as $v) $this->table_cols[]=$v['Field'];
		
		
		 
		if ($id!=0 ||  (strlen($url)>0))
		{ 
			if (strlen($url)>0)
			{
				$this->CI->db->limit(1);
				$this->CI->db->order_by('id','desc');
				$row=$this->CI->db->get_where($this->table,array($key=>$url))->row_array(); 
			} 
			else 
				$row=$this->CI->db->get_where($this->table,array('id'=>$id))->row_array(); 
			if (is_array($row)) foreach ($row as $key => $var) $this->properties[$key] = $row[$key]; 
			if (isset($this->properties['id'])) $this->id=$this->properties['id'];
			 
		}
	} 

	
	public function get_col_settings($settings=[])
	{
		$settings['table_name']=$this->table;
		return $res = $this->CI->db->get_where('table_cols',$settings)->result_array();
	}
	
	public function get_table_cols()
	{
		$cols=[];
		foreach ($this->get_col_settings(['column'=>1]) as $row) 
			$cols[$row['name']]=$row['placeholder'];
			
		return $cols; 
	}
	
	public function set_col_settings()
	{
		if (count($this->col_settings)<1) {
			$res=$this->get_col_settings();
			foreach ($res as $k=>$v) $this->col_settings[$v['name']]=$v;
		}
	}

	public function show_time_filter()
	{
		return false;
	}
	
	function get_filters()
	{
		$filters=[];
		$columns = $this->get_table_cols();
		foreach ($columns  as $k=>$vk)
		{
			
			if (in_array($k,$this->table_cols)) {
				$xx="";
				$xy="  (`{$k}`), `{$k}`  as vv ";
				if (in_array($k,array('from','to'))) {
					$xx="LEFT JOIN `valut` a ON t.{$k}=a.id ";
					$xy = " (`{$k}`) as vv, a.name as `{$k}` ";
				}
				$result = $this->CI->db->query("SELECT  $xy FROM `{$this->table}` t $xx GROUP BY  `{$k}` LIMIT 100")->result_array(); 
				 
				foreach ($result as $v) $filter[$k][$v['vv']]=$v[$k]; 
			}
			else $filter[$k]=array();
		}
		
		return $filter;
	}
	
	function set_meta($key,$value)
	{
		$key=$this->CI->db->escape_str($key);
		$value=$this->CI->db->escape_str($value);
		
		$this->meta_vals[$key]=$value;
		if ($this->id<1) return;
		
		$this->CI->db->query("INSERT INTO `meta_value` SET `meta_key`='{$key}' , `meta_value`='{$value}' ,  `table`='{$this->table}' , `id`='{$this->id}'   
				ON DUPLICATE KEY  UPDATE   `meta_value`='{$value}' ");
	}
	
	function get_meta($key)
	{
		if ($this->loaded==0)
		{
			$this->loaded=1;
			//$key=$this->CI->db->escape_str($key);
			$res=$this->CI->db->get_where('meta_value',array('id'=>$this->id, 'table'=>$this->table))->result_array();
			foreach ($res as $row)
			{
				$this->meta_vals[$row['meta_key']]=$row['meta_value'];
			}
			
		}
			
		return $this->meta_vals[$key];
	}
	
	function __set($name, $value) { 
	
		
		 
		 
		if (!isset($this->$name))
		{
			if (in_array($name,$this->table_cols))//если в таблице нет такого столбца то создаем как мета данные
			{
				$this->properties[$name]=$value;
				$this->properties2[$name]=$value; 
			}
			else $this->set_meta($name,$value);
		}			
			
	}
	
	function __get($name) {	  
		
		if (!in_array($name,$this->table_cols) && !property_exists($this,$name) ) return $this->get_meta($name);
        elseif (isset($this->properties[$name])) return $this->properties[$name]; 
    }
	
	//получение всех элементов таблицы
	public function get_all($limit=50,$st=0,$order='id',$order_type='desc',$where=array()) {	
		$this->CI->db->select($this->table.'.*');
		foreach ($where as $k=>$v) {
			if ($k=='user_id' && !is_numeric($v))
			{
				$this->CI->db->join('users', 'users.id = '.$this->table.'.user_id');
				$this->CI->db->join('meta_value', 'meta_value.id = users.id');
				$this->CI->db->like('users.name',$v);
				$this->CI->db->or_like('meta_value.meta_value',$v);
			}
			else $this->CI->db->where($this->table.'.'.$k,$v);
		}
		$this->CI->db->limit($limit,$st);
		$this->CI->db->order_by($this->table.'.'.$order,$order_type);
		$this->CI->db->group_by($this->table.'.'.'id');
        $result=$this->CI->db->get($this->table)->result_array(); 
		return $result;
    }
	
		//получение всех элементов таблицы
	public function get_all_limit($limit=50,$st=0,$et=0,$order='id',$order_type='desc',$where=array()) {	
		$this->CI->db->select($this->table.'.*');
		foreach ($where as $k=>$v) {
			if ($k=='user_id' && !is_numeric($v))
			{
				$this->CI->db->join('users', 'users.id = '.$this->table.'.user_id');
				$this->CI->db->join('meta_value', 'meta_value.id = users.id');
				$this->CI->db->like('users.name',$v);
				$this->CI->db->or_like('meta_value.meta_value',$v);
			}
			else $this->CI->db->where($this->table.'.'.$k,$v);
		}
		$this->CI->db->limit($limit,$st,$et);
		$this->CI->db->order_by($this->table.'.'.$order,$order_type);
		$this->CI->db->group_by($this->table.'.'.'id');
        $result=$this->CI->db->get($this->table)->result_array(); 
		return $result;
    }
	
	
	public function get_count($where=array()) {	
		$this->CI->db->select('count(id) as count');
		$this->CI->db->from($this->table);

		foreach ($where as $k=>$v) $this->CI->db->where($this->CI->db->escape_str($k),$this->CI->db->escape_str(($v)));
		
        $row=$this->CI->db->get()->row_array(); 
		 
		return (int)$row['count'];
    }
	
	public function get_all_array($limit=50,$st=0,$order='id',$order_type='desc',$where=array()) {	
		return get_all_array($this->get_all($limit ,$st, $order ,$order_type ,$where ));
    }
	
	//удаление элемента
	public function delete()
	{
		$this->CI->db->where('id',$this->id);
		$this->CI->db->delete($this->table); 
		
		$this->CI->db->where('id',$this->id);
		$this->CI->db->where('table',$this->table);
		$this->CI->db->delete('meta_value'); 
		
		$this->properties=array();
		$this->properties2=array();
	}
	
	//сохранение элемента
	public function save() 
	{ 
		
		
		 
		if (sizeof($this->properties2)>=1)
		{  
			$update=array();
			
			foreach($this->properties2 as $key => $val) if (strlen($val))  $update[$key]=$val; 
			
			if (count($update))
			{
				if ($this->id==0 ) {
					$this->CI->db->insert($this->table,$update);  
					$this->id=$this->CI->db->insert_id();
					foreach ($this->meta_vals as $k=>$v) $this->set_meta($k,$v);
					 
				}
				else  { 
					$this->CI->db->where('id',$this->id);
					$this->CI->db->update($this->table,$update); 
				}
				
				$this->properties2 = array(); 
			}
			 
			
		}
	}
	
	//загрузка изображения
	public function img_upload($img_name,$path,$min_width=100,$max_width=1000)
	{ 
		global $admin;
		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|text|plain|txt|mp3|wav';
		if ($admin) $config['allowed_types']='*';
		$config['max_size']             = 50240000;
		$config['max_width']            = 202400;
		$config['max_height']           = 176800;
		 
		$dt=$this->file_upload($img_name,$path,$config);
		 
		if (!isset($dt['error']))
		{
			$new_name='im_'.md5($dt['file_name']).substr($dt['file_name'],-4);
			
			//if (substr($dt['file_name'],-4)!='.pdf')  $this->imageresize($dt['file_path'].$new_name,$min_width,$max_width,$dt['full_path'],100,$dt['image_type']); 
			//else 
				return $dt['file_name'];
			
			return $new_name;
		}
		// else die($dt['error']);
		 else return $dt;
		
	}
	
	public function imageresize($outfile,$min_width,$max_width,$infile,$quality,$type,$water_mark='') {

		if ($type=='jpeg') $im=imagecreatefromjpeg($infile);
		elseif ($type=='png') $im=imagecreatefrompng($infile);
		elseif ($type=='gif') $im=imagecreatefromgif($infile);
		 
			
		$neww=imagesx($im); 
		if ($neww<$min_width) $neww=$min_width;
		if ($neww>$max_width) $neww=$max_width;
		$newh=$neww*imagesy($im)/imagesx($im);

		$im1=imagecreatetruecolor($neww,$newh);
		imagecopyresampled($im1,$im,0,0,0,0,$neww,$newh,imagesx($im),imagesy($im));
		if($neww>=250 && strlen($water_mark)>0)//добавляем водяной знак на изображения больше среднего размера
		{               
			$im_logo = imagecreatefrompng($water_mark);
			imagecopy($im1, $im_logo, 0, 0, 0, 0, 250, 250);
		}
		
		if ($type=='png') copy($infile, $outfile);  
		else imagejpeg($im1,$outfile,$quality);
		 
		
		
		imagedestroy($im);
		imagedestroy($im1);
	}
	
	public function file_upload($file_name,$path,$config=array())
	{
		if (!file_exists($path)) mkdir($path, 777);
		if (count($config)<1)
		{ 
			$config['allowed_types']        = '*';
			$config['max_size']             = 1024;
		}
		$config['upload_path']          = $path;
		
		$this->CI->load->library('upload', $config);

        if ( ! $this->CI->upload->do_upload($file_name))  $data = array('error' => $this->CI->upload->display_errors());
        else $data = $this->CI->upload->data();
		
		return $data;
	}

	
	public function set_js_event($event,$function)
	{
		$this->form_add_html.=" $event=\"{$function}\" ";
		 
	}
	
	//генерация полей формы для админки
	public function generate_form($prop,$type='',$class='',$select_list=array(),$placeholder='',$req=0 )
	{
		if ($req)  $addstr='required';
		else $addstr='';
		$html='';
		
		$this->form_add_html.=''; //тут добавляем доп параметры если надо
		//die('='.$req);
		
		if (!isset($this->properties[$prop]))
		{
			if ($type=='date_time') $this->properties[$prop]=time();  elseif (!in_array($prop,$this->table_cols) && !property_exists($this,$prop) ) $this->properties[$prop]=$this->get_meta($prop);   else $this->properties[$prop]=''; 
		}
			
		switch ($type)
		{
			case 'file_img':
				if (strlen($this->$prop)>0) $html='<img  src="/upload/'.$this->$prop.'" width="50" ><br><a href="/upload/'.$this->$prop.'">Скачать</a> <br>';
				else $html='';
				$html.='<input '.$addstr.' type="file" '.$this->form_add_html.'  id="form_'.$prop.'" name="'.$prop.'"   size="20" />';
			break;
			case 'file_mp3':
				if (strlen($this->$prop)>0) $html=' <a href="/upload/'.$this->$prop.'">Скачать</a> <br>';
				else $html='';
				$html.='<input '.$addstr.' type="file"  '.$this->form_add_html.' id="form_'.$prop.'" name="'.$prop.'"   size="20" />';
			break;
			case 'checkboxone': 
				 
				if ($this->properties[$prop]>0) $sel='checked'; else $sel='';
				$html.='<br><input type="checkbox"  '.$this->form_add_html.' name="'.$prop.'" value="1" '.$sel.' id="'.$prop.'" ><label for="'.$prop.'">'.$placeholder.'</label>' ;
				 
			break;
			case 'checkbox': 
				if (!is_array($select_list))
				{
					$result = $this->CI->db->get($select_list)->result_array();
					$select_list=array();
					foreach ($result as $v) $select_list[$v['id']]=$v['name'];
				}
				foreach ($select_list as $k=>$v)
				{
					 
					if (in_array($k,$this->properties[$prop])) $sel='checked'; else $sel='';
					$html.='<br><input type="checkbox"  '.$this->form_add_html.' name="'.$prop.'[]" value="'.$k.'" '.$sel.' id="'.$prop.'_'.$k.'" ><label for="'.$prop.'_'.$k.'">'.$v.'</label>' ;
				} 
			break;
			case 'select':
				$html='<select id="form_'.$prop.'"  '.$this->form_add_html.' '.$addstr.' name="'.$prop.'"  class="'.$class.'" >';
				if (!is_array($select_list))
				{
					$result = $this->CI->db->get($select_list)->result_array();
					$select_list=array();
					foreach ($result as $v) $select_list[$v['id']]=$v['name'];
					asort($select_list);
				}
				foreach ($select_list as $k=>$v)
				{ 
					if ($k==$this->properties[$prop]) $sel='selected'; else $sel='';
					$html.='<option value="'.$k.'" '.$sel.' >'.$v.'</option>' ;
				}
				$html.='</select>' ;
			break;
			case 'textarea':
				$html='<textarea '.$addstr.'  '.$this->form_add_html.' placeholder="'.$placeholder.'" id="form_'.$prop.'"  class="'.$class.'"  name="'.$prop.'" >'.$this->$prop.'</textarea>' ;
			break;
			case 'date_time':
				$html='<input  '.$addstr.' '.$this->form_add_html.'  placeholder="'.$placeholder.'" id="form_'.$prop.'_date"  type="date" class="'.$class.'" value="'.date('Y-m-d',$this->$prop).'" name="'.$prop.'[date]" />' ;
				$html.='<input '.$addstr.'  '.$this->form_add_html.' placeholder="'.$placeholder.'" id="form_'.$prop.'_time"  type="time" class="'.$class.'" value="'.date('H:i',$this->$prop).'" name="'.$prop.'[time]" />' ;
			break;
			case 'number':
				$html='<input '.$addstr.'  '.$this->form_add_html.' placeholder="'.$placeholder.'" id="form_'.$prop.'" step="0.01" type="number" class="'.$class.'" value="'.$this->$prop.'" name="'.$prop.'" />' ;
			break;
			case 'email':
				$html='<input '.$addstr.'  '.$this->form_add_html.' placeholder="'.$placeholder.'" id="form_'.$prop.'"  type="email" class="'.$class.'" value="'.$this->$prop.'" name="'.$prop.'" />' ;
			break;
			case 'disabled':
			case 'text_disabled':
				$html='<input disabled  '.$this->form_add_html.'   id="form_'.$prop.'"  type="text" class="'.$class.'" value="'.$this->$prop.'" name="'.$prop.'" />' ;
			break;
			case 'desc':
				$html=$placeholder;
			break;
			default:
				$html='<input '.$addstr.' '.$this->form_add_html.' placeholder="'.$placeholder.'" id="form_'.$prop.'"  type="text" class="'.$class.'" value="'.$this->$prop.'" name="'.$prop.'" />' ;
			break;
		}

		$this->form_add_html=''; //обнуляем

		return $html;
	}
	
	public function get_timestamp($date,$time)
	{
		$dt=explode('-',$date);
		$dt2=explode(':',$time);
		return mktime($dt2[0],$dt2[1],0,$dt[1],$dt[2],$dt[0]);
	}

	function __destruct() {		
       if ($this->id>0) $this->save();
   }
}