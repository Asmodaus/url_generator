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
					<strong>Шаблоны</strong>
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
                    
                </div>
                </div> 
			  
			</form>
			<?endif;?> 	
			

    
        <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
		<div class="col-sm-12">
        <select class="selectpicker" multiple id="table_set" OnChange="reform_table()">
			<?foreach ($model->types as $key => $val):?>
			<option selected   value="<?=$key?>"><?=$val?></option>
			<?endforeach;?>
		</select>
		Выберите столбцы для показа
        </div>
        <div class="col-sm-12">
		<form action="?" method="get">
        <table class="table table-hover   nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
            <thead class="thead-default">
            <tr role="row">
					<?foreach ($model->types as $key => $val):?>
					<th  class="sorting <?=$key?> onhide" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
					<?endforeach;?>
                    <?if($model->allow_edit()):?>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Редактировать</th>
					<th  class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки" >Удалить</th>
                    <?endif;?>
            </tr>
            </thead>
           
  


     <tbody>
               
				<?
				$time_start = microtime(); 
			 
				$filter0=$filter;
				$filter0['type']=0;
				foreach ($model->get_all(200,0,'id','desc',$filter0) as $row0):  
				
				$filter1=$filter;
				$filter1['type']=1;
				$filter1['parent_id']=$row0['id'];
				$list1=$model->get_all(200,0,'id','desc',$filter1);
				if (count($list1)==0) $list1=[['value'=>'*']];
				foreach ($list1 as $row1):

				$filter2=$filter;
				$filter2['type']=2;
				$filter2['parent_id']=$row1['id'];
				$list2=$model->get_all(200,0,'id','desc',$filter2);
				if (count($list2)==0) $list2=[['value'=>'*']];
				foreach ($list2 as $row2):

				$filter3=$filter;
				$filter3['type']=3;
				$filter3['parent_id']=$row2['id'];
				$list3=$model->get_all(200,0,'id','desc',$filter3);
				if (count($list3)==0) $list3=[['value'=>'*']];
				foreach ($list3 as $row3):

				$filter4=$filter;
				$filter4['type']=2;
				$filter4['parent_id']=$row3['id'];
				$list4=$model->get_all(200,0,'id','desc',$filter4);
				if (count($list4)==0) $list4=[['value'=>'*']];
				foreach ($list4 as $row4):

				$filter5=$filter;
				$filter5['type']=5;
				$filter5['parent_id']=$row4['id'];
				$list5=$model->get_all(200,0,'id','desc',$filter5);
				if (count($list5)==0) $list5=[['value'=>'*']];
				foreach ($list5 as $row5):
					
				?> 
                 <tr role="row" class="odd">
					 
					<td class="p0 onhide"  ><?=$model->get_table_row('value',$row0)?></td>
					<td class="p1 onhide"  ><?=$model->get_table_row('value',$row1)?></td>
					<td class="p2 onhide"  ><?=$model->get_table_row('value',$row2)?></td>
					<td class="p3 onhide"  ><?=$model->get_table_row('value',$row3)?></td>
					<td class="p4 onhide"  ><?=$model->get_table_row('value',$row4)?></td>
					<td class="p5 onhide"  ><?=$model->get_table_row('value',$row5)?></td>
					 
                    <?if($model->allow_edit()):?>
					<td><a href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>">Редактировать</a></td>
					<td><a OnClick="if (!confirm('Вы уверены что желаете удалить этот элемент?')) return false;" href="<?=$admurl?>edit/<?=$model_name?>/<?=$row['id']?>/delete">Удалить</a></td>
                    <?endif;?>
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
	 
	"processing": true,
	"serverSide": true, 
	"ajax":'/ajax/edit_list/<?=$model_name?>?time1=<?=strtotime($_GET['time1'])?>&time2=<?=strtotime($_GET['time2'])?><?=$filter?>',
	
	// "ajax": {
	//	"url": '/ajax/edit_list/users',
	//	"dataType": "jsonp"
	//}, 
});
}

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
	  