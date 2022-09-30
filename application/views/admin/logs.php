<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
<section class="card">
    <div class="card-header">
        <span class="cat__core__title">
            <strong>Логи <?=$model_name?></strong>
</span>
    </div>
    			<?if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
						if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d');
				?>
    <div class="card-block">
    <div class="mb-5">
						<form action='?' id='form1' method="get">
                    <div class="row">
						 
                        <div class="col-lg-3">
                            <input type="date" id="time13" name="time1" value="<?=date('Y-m-d',strtotime($_GET['time1']))?>" class="form-control  width-200 display-inline-block mr-2 mb-2" placeholder="выберите дату от" />
                        </div>
                        <div class="col-lg-1">
                            <div class="text-center mt-2">—</div>
                        </div>
                        <div class="col-lg-3">
                            <input type="date"  id="time23" name="time2" value="<?=date('Y-m-d',strtotime($_GET['time2']))?>"class="form-control  width-200 display-inline-block mr-2 mb-2" placeholder="выберите дату до" />
                        </div>
                        <div class="col-lg-3">
                        	<button type="submit" class="btn btn-rounded btn-default display-inline-block mr-2 mb-2">Применить</button>
                        </div>
                    </div>
					</form>
                    <hr />
                    <div class="mb-5" style="padding-left:10px;">
                    <div class="row">
                    <ul class="list-inline">
  					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="$('#time13').val('<?=date('Y-m-d')?>');$('#time23').val('<?=date('Y-m-d')?>');" class="cat__core__link--underlined mr-2">Сегодня</a></li>
 					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="$('#time13').val('<?=date('Y-m-d',time()-24*3600)?>');$('#time23').val('<?=date('Y-m-d',time()-24*3600)?>');" class="cat__core__link--underlined mr-2">Вчера</a></li>
  					<li class="list-inline-item"><a href="javascript: void(0);"  OnClick="$('#time13').val('<?=date('Y-m-d',time()-24*3600*7)?>');$('#time23').val('<?=date('Y-m-d',time())?>');" class="cat__core__link--underlined mr-2">За 7 дней</a></li>
  					<li class="list-inline-item"><a href="javascript: void(0);" OnClick="$('#time13').val('<?=date('Y-m-d',time()-24*3600*30)?>');$('#time23').val('<?=date('Y-m-d',time())?>');" class="cat__core__link--underlined mr-2">30 дней</a></li>
					</ul>
                    </div>
                </div>
                </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-5">
                    <table class="table table-hover nowrap" id="example2" width="100%">
                        <thead>
                            <tr>
                                <?foreach ($model->get_table_cols('log') as $val):?>
								<th><?=$val?></th>
								<?endforeach;?> 
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <?foreach ($model->get_table_cols('log') as $val):?>
								<th><?=$val?></th>
								<?endforeach;?> 
                            </tr>
                        </tfoot>
                        <tbody>
                           <?foreach ($model->get_log($log_type) as $row):?>
							<tr>
								<?foreach ($model->get_table_cols('log') as $key => $val):?>
								<td title="<?=$val?>"><?=$model->get_table_row($key,$row)?></td>
								<?endforeach;?> 
							 </tr>
							<?endforeach;?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section> 
			  

<?include('footer2.php');?>
<script>
    $(function(){

        $('#example2').DataTable({
            autoWidth: true,
            scrollX: true,
            fixedColumns: true,
            "order": [[ 1, "desc" ]]
        });

    });
</script>
<!-- DataTables -->
</body>
</html>