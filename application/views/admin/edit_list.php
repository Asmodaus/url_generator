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
                    <?if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
                        if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d');
                        ?>
                    <div class="filter_section">
						<div class="row mx-n1">
                            <?if($model_name=='links'):?>
							<div class="col-12 col-xl-7 px-1">
								<div class="row mx-n1">
									<div class="col px-1">
										<select class="custom-select fz_12">
											<option selected="">По источнику</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
									</div>
									<div class="col px-1">
										<select class="custom-select fz_12">
											<option selected="">По параметрам</option>
											<option value="1">One</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
									</div>
									<div class="col px-1">
										<select class="custom-select fz_12">
											<option selected="">По значениям</option>
											<option value="1">Lorem ipsum,</option>
											<option value="2">Two</option>
											<option value="3">Three</option>
										</select>
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
								<a href="#" class="btn btn-danger fz_12 d-inline-flex align-items-center">
									<i class="fas fa-table fz_16 mr-2"></i>
									Скачать таблицу
								</a>
							</div>
							<div class="col px-1 mt-2">
								<div class="input-group cstm_search">
									<input type="text" class="form-control fz_12">
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
                    <?endif;?>
					<table class="table table-bordered table-white   table-hover  nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
						<thead>
							<tr>
                            <?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"><?=$val?> </th>
                            <?endforeach;?>
                            <?if($model->allow_edit()):?>
                            <th class="fz_14 font-weight-normal text-center">Редактировать</th> 
                            <?endif;?> 
							</tr>
						</thead>
						<tbody>
                         <?    foreach ($model->get_all(20,0,'id','desc',$filter) as $row):?>
                            <tr role="row">
                                <?if($model_name=='links'):?>
                                    <td class="fz_14 text-center">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" disabled OnClick="copy('link_<?=$row['id']?>')" id="link_<?=$row['id']?>" class="form-control" value="<?=$row['link']?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger showComment_js" type="button ">
                                                    <i class="far fa-comment fz_16"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="hidden_text pt-1">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" OnChange="ajax('link_comment','text='+this.value+'&id=<?=$row['id']?>','1');" placeholder="mysite.ru"> 
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" disabled OnClick="copy('link2_<?=$row['id']?>')" id="link2_<?=$row['id']?>" value="<?=$row['short_link']?>"> 
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
                            <?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1" class="fz_14 font-weight-normal text-center"><?=$val?> </th>
                            <?endforeach;?>
                            <?if($model->allow_edit()):?>
                            <th class="fz_14 font-weight-normal text-center">Редактировать</th> 
                            <?endif;?> 
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
  
	  