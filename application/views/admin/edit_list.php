<?php
defined('BASEPATH') OR exit('No direct script access allowed');



include('header2.php');
?> 
	
    <div class="main px-3 py-5">
			<div class="centered">
				<div class="panel p-5 mb-4">
					<div class="title_page d-flex align-items-center flex-wrap pb-3">
						<h2 class="fz_30 bold_font pr-3 mb-0"><?=$model->title()?></h2>
                        <?if($model->allow_edit()):?>
						<a href="<?=$admurl?>edit/<?=$model_name?>/0/add" class="fas fa-plus-square text-danger tdn fz_30"></a>
                        <?endif;?>
					</div>

                    <?if ($model->show_time_filter() ):?>
                    <form action='?' id='form1' method="get">  
                    <div class="filter_section">
						<div class="row mx-n1">
                            <?if($model_name=='Links'):?>
							<div class="col-12 col-xl-7 px-1">
								<div class="row mx-n1">
									<div class="col px-1">
										<select  name="filter[p0]"  class="custom-select fz_12">
											<option value="0" selected="">По источнику</option>
											<?foreach ($p0 as $row):?>
											<option <?=($row['id']==$_GET['filter']['p0'] ? 'selected' : '')?> value="<?=$row['id']?>"><?=$row['value']?></option>
											<?endforeach;?>
										</select>
									</div>
									<div class="col px-1">
										<select  name="param"  class="custom-select fz_12">
											<option  value="0" selected="">По параметрам</option>
											<?foreach ((new Template($this))->types as $k=>$v):?>
											<option <?=('p'.$k.'_text'==$_GET['param']  ? 'selected' : '')?> value="p<?=$k?>_text"><?=$v?></option>
											<?endforeach;?>
										</select>
									</div>
									<div class="col px-1">
										<input class="fz_12 form-control" value="<?=$_GET['value']?>" placeholder="Значение" name="value" >
									</div>
								</div>
							</div>
                            <?endif;?>
							<div class="col-12 col-xl-5 px-1 mt-2 mt-xl-0">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text fz_12">Дата с:</span>
									</div>
									<input class="form-control fz_12" type="date" type="date"   name="time1" value="<?=date('Y-m-d',strtotime($_GET['time1']))?>" >
									<div class="input-group-prepend">
										<span class="input-group-text fz_12">Дата по:</span>
									</div>
									<input class="form-control fz_12"   id="date2"  type="date"   name="time2" value="<?=date('Y-m-d',strtotime($_GET['time2']))?>"  >
								</div>
							</div>
							 
							<div class="col-auto px-1 mt-2">
								<a href="/admin55/edit/<?=$model_name?>/0/csv?<?=http_build_query($_GET)?>" class="btn btn-danger fz_12 d-inline-flex align-items-center">
									<i class="fas fa-table fz_16 mr-2"></i>
									Скачать таблицу
								</a>
							</div>
							<div class="col-auto px-1 mt-2">
								<a href="javascript:" OnClick="$('#import').click();" class="btn btn-danger fz_12 d-inline-flex align-items-center">
									<i class="fas fa-table fz_16 mr-2"></i>
									Загрузить таблцу
								</a>
							</div>
							<div class="col px-1 mt-2">
								<div class="input-group cstm_search">
									<input type="text" name="filter[url]"  value="<?=$_GET['filter']['url']?>"  class="form-control fz_12">

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
					
					<form action="/admin55/import_excel" enctype="multipart/form-data"  method="post" id="import_form" style="display: none;" >
						<input  style="display: none;" type="file" name="file" id="import" OnChange="$('#import_form').submit();" >
						<input  style="display: none;" type="submit">
					</form>
                    <?endif;?>
					<div class="table-responsive ">
					<table class="table table-bordered table-white  table-hover  nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
						<thead>
							<tr>
                            <?if($model_name=='Links'):?>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"> </th>
                            <?else:?>
                                <?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"><?=$val?> </th>
                                <?endforeach;?>
                            <?endif;?> 
                            <?if($model->allow_edit()):?>
                            <th class="fz_14 font-weight-normal text-center">Редактировать</th> 
                            <?endif;?> 
							</tr>
						</thead>
						<tbody>
                         <?    foreach ($edit_list as $row):
                            $Us = new $model_name($this,$row['id']);
                            ?>
                            <tr role="row">
                                <?if($model_name=='Links'):?>
                                    <td class="fz_14 text-center">
                                    <div class="form-group mb-0">
                                        <div class="input-group">
                                            <input type="text"   OnClick="copy('link_<?=$row['id']?>')" id="link_<?=$row['id']?>" class="form-control" value="<?=$row['url']?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger showComment_js" type="button ">
                                                    <i class="far fa-comment fz_16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="hidden_text pt-1 px-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Введите комментарий" OnChange="ajax('link_comment','text='+this.value+'&id=<?=$row['id']?>','1');"  value="<?=$row['text']?>"> 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <input type="text"   class="form-control"   OnClick="copy('link2_<?=$row['id']?>')" id="link2_<?=$row['id']?>" value="<?=$row['s_url']?>"> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                <?else:?>
                                    <?foreach ($model->get_table_cols( ) as $key => $val):
                                
                                        if ($Us->$key) $row[$key]=$Us->$key; 
                                    ?>
                                    <td class="<?=$key?>  fz_14 txt_wraperd" title="<?=$val?>"><?=$model->get_table_row($key,$row,$Us);?></td>
                                    <?endforeach;?> 
                                    <?if($model->allow_edit()):?>
                                    <td class="fz_14 text-center">
                                        <a href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>" class="fas fa-user-edit text-dark fz_18 mx-1 tdn"></a>
                                        <a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>/delete" class="fas fa-times-circle text-danger fz_18 mx-1 tdn"></a>
                                    </td>
                                    <?endif;?>
                                

                                <?endif;?>
							</tr> 
                            <?endforeach;?> 
						</tbody>
                        <tfoot>
							<tr>
                            <?if($model_name=='Links'):?>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"> </th>
                            <?else:?>
                            <?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"><?=$val?> </th>
                            <?endforeach;?>
                            <?endif;?> 
                            <?if($model->allow_edit()):?>
                            <th class="fz_14 font-weight-normal text-center">Редактировать</th> 
                            <?endif;?> 
							</tr>
						</tfoot>
					</table>
					</div>
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
  
	  