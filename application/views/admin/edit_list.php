<?php
defined('BASEPATH') OR exit('No direct script access allowed');



include('header2.php');
?> 

<div class="cat__top-bar">
    <!-- left aligned items -->
    <div class="cat__top-bar__left">
        <div class="cat__top-bar__logo">
            <!--<a href="dashboards-alpha.html">
                <img src="<?=$path?>modules/dummy-assets/common/img/logo.png" />
            </a>-->
        </div>
    </div>
    <!-- right aligned items -->
</div>
<div class="cat__content"> 
<section class="card">
<div class="card-block"> 
			<div class="box-body">
			  <a href="<?=$admurl?>edit/<?=$model_name?>/0/add"><button type="button" class="btn btn-block btn-primary">Создать</button></a>
              <? /*
              <a href="<?=$admurl?>edit/<?=$model_name?>/0/csv?time1=<?=$_GET['time1']?>&time2=<?=$_GET['time2']?>"><button type="button" class="btn btn-block btn-primary">Скачать CSV</button></a>
           */ ?>
             
			</div>
</div>
</section>		
<section class="card">
			<div class="card-header">
				<span class="cat__core__title">
					<strong><?=$model_name?></strong>
				</span>
			</div> 	 

			<div class="card-block">		 
			 
			<?if ($model->show_time_filter() ):?>
			<form action='?' id='form1' method="get"> 
			<?if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
				if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d');
				?>
			 <div class="mb-5">
                    <div class="row">
                        <div class="col-lg-3">
                            <input class="form-control  width-200 display-inline-block mr-2 mb-2"  type="date" id="time1" name="time1" value="<?=date('Y-m-d',strtotime($_GET['time1']))?>" placeholder="выберите дату от" />
                        </div>
                        <div class="col-lg-1">
                            <div class="text-center mt-2">—</div>
                        </div>
                        <div class="col-lg-3">
                            <input  type="date" id="time2" name="time2" value="<?=date('Y-m-d',strtotime($_GET['time2']))?>" class="form-control   width-200 display-inline-block mr-2 mb-2" placeholder="выберите дату до" />
                        </div>
                        <div class="col-lg-3">
                        	<button type="submit" class="btn btn-rounded btn-default display-inline-block mr-2 mb-2">Применить</button>
                        </div>
                    </div>
                    <hr />
                    <div class="mb-5" style="padding-left:10px;">
                    <div class="row">
                    <ul class="list-inline">
  					<li class="list-inline-item"><a href="javascript: void(0);"  OnClick="$('#time1').val('<?=date('Y-m-d')?>');$('#time2').val('<?=date('Y-m-d')?>');" class="cat__core__link--underlined mr-2">Сегодня</a></li>
 					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600)?>');$('#time2').val('<?=date('Y-m-d',time()-24*3600)?>');" class="cat__core__link--underlined mr-2">Вчера</a></li>
  					<li class="list-inline-item"><a href="javascript: void(0);"  OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*7)?>');$('#time2').val('<?=date('Y-m-d',time())?>');"class="cat__core__link--underlined mr-2">За 7 дней</a></li>
  					<li class="list-inline-item"><a href="javascript: void(0);"  OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*30)?>');$('#time2').val('<?=date('Y-m-d',time())?>');"class="cat__core__link--underlined mr-2">30 дней</a></li>
  					<?if( $model_name!='Exchange_Cash'):?>
					<li class="list-inline-item"><a href="javascript: void(0);"  OnClick="window.location='<?=$admurl?>export_excel/<?=$model_name?>?time1='+$('#time1').val()+'&time2='+$('#time2').val()+'&api='+$('#api').val()+'&valut='+$('#valut').val();"  class="cat__core__link--underlined mr-2">Экспорт в <img src="https://png.icons8.com/microsoft-excel/color/24" title="Microsoft Excel" width="24" height="24"></a></li>
					<?endif;?> 	 
					<?if( $model_name=='Exchange_Cash'):?>
					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="window.location='<?=$admurl?>save_invoices?partner_id=<?=$P->id?>&time1='+$('#time1').val()+'&time2='+$('#time2').val();" class="cat__core__link--underlined mr-2">Экспорт в <img src="https://png.icons8.com/winrar/color/24" title="WinRAR" width="24" height="24"></a></li>
					
					<?elseif($model_name=='Transactions'  ):?>
					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="window.location='<?=$admurl?>save_invoices?time1='+$('#time1').val()+'&time2='+$('#time2').val()+'&api='+$('#api').val()+'&valut='+$('#valut').val();" class="cat__core__link--underlined mr-2">Экспорт в <img src="https://png.icons8.com/winrar/color/24" title="WinRAR" width="24" height="24"></a></li>
					<?endif;?> 	 
					</ul>
                    </div>  
                </div>
                </div> 
			  
			</form>
			<?endif;?> 	
			

    
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
		<form action="?" method="get">
        <table class="table table-hover <?if (strpos(  $model_name,'Transactions')!==false ):?><?endif;?> nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
            <thead class="thead-default">
            <tr role="row">
			<?foreach ($model->get_table_cols('',$user->id) as $key => $val):?>
					<th  class="sorting <?=$key?> onhide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
					<?endforeach;?>
                    <?if($model->allow_edit()):?>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Редактировать</th>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Удалить</th>
                    <?endif;?>
            </tr>
            </thead>
           
  


     <tbody>
                <?if(count($model->show_filters())):?>
			     <tr >
				
					<?foreach ($model->get_table_cols('',$user->id) as $k=>$val):?>
					<th  ><input type="text" style="width:80px;" value="<?=$_GET['filter'][$k]?>" name="filter[<?=$k?>]" ></th>
					<?endforeach;?>
					<th  ><input  type="submit" value="Применить"> </th>
					<th  > </th>
					
                </tr>
                <?endif;?>
				<?
				$time_start = microtime(); 
			 
				foreach ($model->get_all(20,0,'id','desc',$filter) as $row):
				 $Us = new $model_name($this,$row['id']); 
				 
				?>
				 
				
				
                 <tr role="row" class="odd">
					<?foreach ($model->get_table_cols( ) as $key => $val):
					
					 $row[$key]=$Us->$key; 
					?>
					<td class="<?=$key?> onhide" title="<?=$val?>"><?=$model->get_table_row($key,$row,$Us)
					?></td>
					<?endforeach;?> 
                    <?if($model->allow_edit()):?>
					<td><a href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>">Редактировать</a></td>
					<td><a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>/delete">Удалить</a></td>
                    <?endif;?>
                </tr>
				<? 
				endforeach; ?>  
            </tbody>
			
			
			
			
			 <tfoot>
            <tr>
					<?foreach ($model->get_table_cols('') as $key => $val):?>
					<th class="<?=$key?> onhide" >  </th>
					<?endforeach;?>
                    <?if($model->allow_edit()):?>
					<th  rowspan="1" colspan="1"   >Редактировать</th>
					<th   rowspan="1" colspan="1"   >Удалить</th>
                    <?endif;?>
            
            </tr>
            </tfoot>
        </table>
		</form>
		</div></div>
        
        </div>
    </div>
 
</section>
 
<script>
    $(function() {

        ///////////////////////////////////////////////////
        // SIDEBAR CURRENT STATE
        $('.cat__apps__messaging__tab').on('click', function(){
            $('.cat__apps__messaging__tab').removeClass('cat__apps__messaging__tab--selected');
            $(this).addClass('cat__apps__messaging__tab--selected');
        });

        ///////////////////////////////////////////////////////////
        // CUSTOM SCROLL
        if (!(/Mobi/.test(navigator.userAgent)) && jQuery().jScrollPane) {
            $('.custom-scroll').each(function() {
                $(this).jScrollPane({
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100
                });
                var api = $(this).data('jsp'),
                        throttleTimeout;
                $(window).bind('resize', function() {
                    if (!throttleTimeout) {
                        throttleTimeout = setTimeout(function() {
                            api.reinitialise();
                            throttleTimeout = null;
                        }, 50);
                    }
                });
            });
        }

        ///////////////////////////////////////////////////////////
        // ADJUSTABLE TEXTAREA
        autosize($('.adjustable-textarea'));

    });
</script>
 
<script>
    $(function () {

        // Datatables
        renew_tables();

    })
	
	function renew_tables()
	{
		$('#example1').DataTable({
            "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]],
            responsive: true,
            "autoWidth": false,
			
			<?if($model_name=='Users' || 1==1):
			$filter='';
			foreach ($_GET['filter'] as $k=>$v)
				$filter.="&filter[{$k}]={$v}";
			?>
			"processing": true,
			"serverSide": true, 
			"ajax":'/ajax/edit_list/<?=$model_name?>?time1=<?=strtotime($_GET['time1'])?>&time2=<?=strtotime($_GET['time2'])?><?=$filter?>',
			
			// "ajax": {
			//	"url": '/ajax/edit_list/users',
			//	"dataType": "jsonp"
			//},
			 <?endif;?>
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
<!-- END: Page Scripts -->
<a href="javascript: void(0);" class="cat__core__scroll-top" onclick="$('body, html').animate({'scrollTop': 0}, 500);"><i class="icmn-arrow-up"></i></a>
 

<?include('footer2.php');?>
	  