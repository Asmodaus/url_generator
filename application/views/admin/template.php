<?php
defined('BASEPATH') OR exit('No direct script access allowed');



include('header2.php');
?> 
	
    <div class="main px-3 py-5">
			<div class="centered">
				<div class="panel p-5 mb-4">
					<div class="title_page d-flex align-items-center flex-wrap pb-3">
						<h2 class="fz_30 bold_font pr-3 mb-0"><?=$model->title()?></h2>
                       
						<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
                       
					</div>
 
                    <form action='?' id='form1' method="get"> 
                   
                    <div class="filter_section">
						<div class="row mx-n1">
                             
							<div class="col px-1 mt-2">
								<div class="input-group cstm_search">
									<div class="col px-1">
										<select  name="filter[type]"  class="custom-select fz_12">
											<option  value="0" selected="">По параметрам</option>
											<?foreach ((new Template($this))->types as $k=>$v):?>
											<option <?=($k==$_GET['filter']['type']  ? 'selected' : '')?> value="<?=$k?>"><?=$v?></option>
											<?endforeach;?>
										</select>
									</div>
									<div class="col px-1">
										<input class="fz_12 form-control" value="<?=$_GET['filter']['value']?>" placeholder="Значение" name="filter[value]" >
									</div>

									<div class="input-group-append">
										<button class="btn btn-dark_green text-white px-4" type="submit ">
											<i class="fa fa-search fz_15"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    </form>
                  
					<table class="table table-bordered table-white   table-hover  nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
						<thead>
							<tr>
							<?foreach ($model->types as $key => $val):?>
							<th  class="sorting <?=$key?> onhide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
							<?endforeach;?>
							</tr>
						</thead>
						<tbody>
						<?
						$time_start = microtime(); 
					
						if ($filter['type']==0) $filter0=$filter;
						$filter0['type']=0;
						foreach ($model->get_all(200,0,'id','desc',$filter0) as $row0):  
						
						if ($filter['type']==1) $filter1=$filter;
						$filter1['type']=1;
						$filter1['parent_id']=$row0['id'];
						$list1=$model->get_all(200,0,'id','desc',$filter1);
						if (count($list1)==0) $list1=[['value'=>'*']];
						foreach ($list1 as $row1):

						if ($filter['type']==2)  $filter2=$filter;
						$filter2['type']=2;
						$filter2['parent_id']=$row1['id'];
						$list2=$model->get_all(200,0,'id','desc',$filter2);
						if (count($list2)==0) $list2=[['value'=>'*']];
						foreach ($list2 as $row2):

						if ($filter['type']==3) $filter3=$filter;
						$filter3['type']=3;
						$filter3['parent_id']=$row2['id'];
						$list3=$model->get_all(200,0,'id','desc',$filter3);
						if (count($list3)==0) $list3=[['value'=>'*']];
						foreach ($list3 as $row3):

						if ($filter['type']==4) $filter4=$filter;
						$filter4['type']=4;
						$filter4['parent_id']=$row3['id'];
						$list4=$model->get_all(200,0,'id','desc',$filter4);
						if (count($list4)==0) $list4=[['value'=>'*']];
						foreach ($list4 as $row4):

						if ($filter['type']==5) $filter5=$filter;
						$filter5['type']=5;
						$filter5['parent_id']=$row4['id'];
						$list5=$model->get_all(200,0,'id','desc',$filter5);
						if (count($list5)==0) $list5=[['value'=>'*']];
						foreach ($list5 as $row5):
							
						?> 
						<tr role="row" class="odd">
							
							<td class="p0 onhide"  > <?=$model->get_table_row('value',$row0)?><a href="<?=$admurl?>edit/template/<?=$row0['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
							<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row0['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a></td>
							<td class="p1 onhide"  > 
								<?if ($row1['id']):?>	
								<?=$model->get_table_row('value',$row1)?><a href="<?=$admurl?>edit/template/<?=$row1['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
								<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row1['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
								<?else:?>
								<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
								<?endif;?>
							</td>
							<td class="p2 onhide"  > 
							<?if ($row2['id']):?>	
								<?=$model->get_table_row('value',$row2)?><a href="<?=$admurl?>edit/template/<?=$row2['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
								<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row2['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
							<?else:?>
							<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
							<?endif;?></td>
							<td class="p3 onhide"  > 
							<?if ($row3['id']):?>	
							<?=$model->get_table_row('value',$row3)?><a href="<?=$admurl?>edit/template/<?=$row3['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
							<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row3['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
							<?else:?>
							<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
							<?endif;?>
							</td>
							<td class="p4 onhide"  > 
							<?if ($row4['id']):?>	
							<?=$model->get_table_row('value',$row4)?><a href="<?=$admurl?>edit/template/<?=$row4['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
							<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row4['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
							<?else:?>
							<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
							<?endif;?>
							</td>
							<td class="p5 onhide"  > 
							<?if ($row5['id']):?>
								<?=$model->get_table_row('value',$row5)?>
								<a href="<?=$admurl?>edit/template/<?=$row5['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
								<a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row5['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
							<?else:?>
							<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
							<?endif;?>
							</td>
							 
						</tr>
						<?endforeach; ?>  
						<?endforeach; ?>  
						<?endforeach; ?>  
						<?endforeach; ?>  
						<?endforeach; ?>  
						<?endforeach; ?>  
							 
						</tbody>
                        <tfoot>
							<tr>
                            <?foreach ($model->types as $key => $val):?>
							<th  class="sorting <?=$key?> onhide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
							<?endforeach;?>
							</tr>
						</tfoot>
					</table>
				 
				</div>
			</div>
		</div>


        <script>
    $(function () {

        // Datatables
        renew_tables();

    })
	
	function renew_tables()
	{
		$('#example1').DataTable({
            "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "Все"]],
            responsive: true,
            "autoWidth": false,
			"language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Russian.json"
            },
			 
			"processing": true,
			"serverSide": true, 
			"ajax":'/ajax/edit_list/<?=$model_name?>?time1=<?=strtotime($_GET['time1'])?>&time2=<?=strtotime($_GET['time2'])?><?=$filter?>',
			
			// "ajax": {
			//	"url": '/ajax/edit_list/users',
			//	"dataType": "jsonp"
			//},
			  
			 "order": [[ 1, "desc" ]]
        });
	}
 
	
	function reform_table()
	{
		$('.onhide').hide();
		$("#table_set :selected").map(function(i, el) {
			console.log($(el).val());
			$('.'+$(el).val()).show();
		});
	}
</script>
<?include('footer2.php');?>  