
			<div class="card-block">		 
	 

    
        <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
		<div class="col-sm-12">
        <select class="selectpicker" multiple id="table_set" OnChange="reform_table()">
			<?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
			<option selected   value="<?=$key?>"><?=$val?></option>
			<?endforeach;?>
		</select>
		Выберите столбцы для показа
        </div>
        <div class="col-sm-12">
		<form action="?" method="get" >
        <table class="table table-hover <?if (strpos(  $model_name,'Transactions')!==false ):?>table-responsive<?endif;?> nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
            <thead class="thead-default">
            <tr role="row">
			<?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
					<th  class="sorting <?=$key?> onhide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
					<?endforeach;?>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Редактировать</th>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Удалить</th>
            </tr>
            </thead>
           
            <tbody>
			 
				<?foreach ($this->db->query("SELECT l.*, u.email as user_id, m1.meta_value as users_ip, 
				c.name as users_country_id, m3.meta_value as users_zip, m4.meta_value as users_street 
				FROM user_aprove_log l , users u  
				LEFT JOIN meta_value m1 ON m1.table='users' AND m1.id=u.id AND m1.meta_key='ip'
				LEFT JOIN meta_value m2 ON m2.table='users' AND m2.id=u.id AND m2.meta_key='country_id'
				LEFT JOIN country c ON c.id=m2.meta_value
				LEFT JOIN meta_value m3 ON m3.table='users' AND m3.id=u.id AND m3.meta_key='zip'
				LEFT JOIN meta_value m4 ON m4.table='users' AND m4.id=u.id AND m4.meta_key='street'
				 WHERE   u.id=l.user_id ORDER BY l.id DESC LIMIT 1000 ")->result_array() as $row):
				 
				?>
                 <tr role="row" class="odd">
					<?foreach ($model->get_table_cols('',$user->id) as $key => $val):
					
					 
					?>
					<td class="<?=$key?> onhide" title="<?=$val?>"><?=$model->get_table_row($key,$row)?></td>
					<?endforeach;?> 
					<td><a href="/admin55/edit/<?=$model_name?>/<?=$row['id']?>">Редактировать</a></td>
					<td><a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="/admin55/edit/<?=$model_name?>/<?=$row['id']?>/delete">Удалить</a></td>
                </tr>
				<? endforeach;?>  
            </tbody>
			 <tfoot>
            <tr>
					<?foreach ($model->get_table_cols('') as $key => $val):?>
					<th class="<?=$key?> onhide" ><? if (isset($res[$key])) foreach ($res[$key] as $k=>$v) { $vl=row('valut',$k); echo '<br>'.number_format($v,2,',','').' '.$vl['name']; }?> </th>
					<?endforeach;?>
					<th  rowspan="1" colspan="1"   >Редактировать</th>
					<th   rowspan="1" colspan="1"   >Удалить</th>
            
            </tr>
            </tfoot>
        </table>
		</form>
		</div></div>
        
        </div>
    </div>
