<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
<section class="card">
    <div class="card-header">
        <span class="cat__core__title">
            <strong>Подтверждение <?=$model_name?></strong>
        </span>
    </div>
    <div class="card-block">
        <div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
        <div class="col-sm-12">
        <table class="table table-hover nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
            <thead class="thead-default">
            <tr role="row">
			<?foreach ($model->get_table_cols('confirmation') as $val):?>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки"><?=$val?></th>
			<?endforeach;?>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки">Действие</th>
				<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Нажмите для сортировки">Действие</th>
			
			</tr>
            </thead>
            <tfoot>
            <tr>
            <?foreach ($model->get_table_cols('confirmation') as $val):?>
				<th   rowspan="1" colspan="1"><?=$val?></th>
			<?endforeach;?> 
				<th rowspan="1" colspan="1" style="">Действие</th>
				<th rowspan="1" colspan="1" style="">Действие</th>
            </tr>
            </tfoot>
            <tbody>
			<?foreach ($model->confirmation_get() as $row):
				$Us = new $model_name($this,$row['id']);
				
						 
				?>
				<tr role="row" class="odd" <?if ($row['status']==1) echo ' style="color:red;" ';?> id="row<?=$row['id']?>">
              
					<?foreach ($model->get_table_cols('confirmation') as $key => $val):
					if (!isset($row[$key])) $row[$key]=$Us->$key;
					?>
					<td style="" title="<?=$val?>"><?=$model->get_table_row($key,$row,$Us)?></td>
					<?endforeach;?> 
					<td style="">
					<?if($model_name=='Users'):?>
						<a href="javascript: void(0);" OnClick="$('#row_val_conf').val('<?=$row['id']?>');" class="bconfdic  cat__core__link--underlined" data-toggle="modal" data-target="#confirm"><small><i class="icmn-checkmark"></i></small> Подтвердить</a>
					<?else:?>
					<a href="javascript: void(0);"  OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/<?=$row['id']?>/accept','','#row<?=$row['id']?>');" class="bconfaccept cat__core__link--underlined mr-2"><i class="icmn-checkmark"></i> Подтвердить</a>
					<?endif;?>
					</td>
					<td style="">
						<a href="javascript: void(0);" OnClick="$('#row_val').val('<?=$row['id']?>');" class="bconfdic  cat__core__link--underlined" data-toggle="modal" data-target="#decline"><small><i class="icmn-cross"></i></small> Отказать</a>
					</td>
                </tr>
				<?endforeach;?>  
            </tr>
            </tbody>
        </table></div></div>
        
        </div>
    </div>
</section>
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Доступные процессинги</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
	  
		<div class="form-group">
            <label for="proc_other" class="form-control-label">Процессинг Other:</label>
            <select  class="form-control"   id="proc_other" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>
		 <div class="form-group">
            <label for="proc_visa" class="form-control-label">Процессинг VISA:</label>
            <select  class="form-control"   id="proc_visa" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>
		<div class="form-group">
            <label for="proc_mastercard" class="form-control-label">Процессинг MasterCard:</label>
            <select  class="form-control"     id="proc_mastercard" >
				<?foreach ((new Pay_Methods($this))->get_all(100,0,'id','asc',['card_processing'=>1]) as $row):?>
					<option  value="<?=$row['id']?>"><?=$row['proc_name']?></option>
				<?endforeach;?>
			</select>
          </div>		  
          <div class="form-group">
            <label for="proc_com" class="form-control-label">Комиссия процессинга:</label>
            <input type="text" id="proc_com"  required  class="form-control"   value="<?=vars('card_com')?>" >
          </div>
		  <div class="form-group">
            <label for="proc_com" class="form-control-label">Наша комиссия:</label>
            <input type="text" id="btc_com"  required  class="form-control"   value="<?=vars('btc_com')?>" >
          </div>
			<input id="row_val_conf" type="hidden" value="" > 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" data-dismiss="modal" OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/'+$('#row_val_conf').val()+'/accept','proc_com='+$('#proc_com').val()+'&proc_visa='+$('#proc_visa').val()+'&proc_mastercard='+$('#proc_mastercard').val()+'&btc_com='+$('#btc_com').val()+'&proc_other='+$('#proc_other').val(),'#row'+$('#row_val_conf').val());" class="btn btn-danger">Принять</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Отказв проверке</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<?if ($model_name=='Users'):?>
			Отказанные документы:
			<?foreach (['bank'=>'Фото','adresdoc'=>'Адрес', 'passport'=>'Паспорт','passport2'=>'Обратная сторона'] as $key=>$doc):?>
			<br><input type="checkbox" value="<?=$key?>" name="doc[]"> <?=$doc?>
			<?endforeach;?>
			<?endif;?>
			
			
          <div class="form-group">
            <label for="message-text" class="form-control-label">Причина отказа:</label>
            <textarea class="form-control" id="dic"></textarea>
			
			<input id="row_val" type="hidden" value="" > 
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" data-dismiss="modal" OnClick="$('.child').remove();if (confirm('Вы уверены?')) ajax('admin_confirm/<?=$model_name?>/'+$('#row_val').val()+'/decline','text='+$('#dic').val()+'&doc='+$('input[name=\'doc[]\']:checked').map(function(){return $(this).val();}).get(),'#row'+$('#row_val').val());" class="btn btn-danger">Отказать</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="photopass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Просмотр документов <a id="passport_doc_load" href="">(Скачать)</a></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="passport_doc" src="https://upload.wikimedia.org/wikipedia/commons/6/63/ID-card_CZ_2012.jpg" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="photoutility" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Просмотр документов <a id="bank_doc_load" href="">(Скачать)</a></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="bank_doc" src="http://vancouver.ca/images/cov/content/John-UtilityBill-NoLabels.png" class="img-fluid" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<!-- START: page scripts -->
<div class="modal fade" id="info-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Информация о пользователе</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <dl class="row" id="user_info_ajax">
                       </dl>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <a id="user_edit_ajax" href=""><button type="button" class="btn btn-info">Детали</button></a>
      </div>
    </div>
  </div>
</div>
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
        $('#example1').DataTable({
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            responsive: true,
            "autoWidth": false,
			 "order": [[ 0, "desc" ]]
        });

    })
</script>



  
<?if ($model_name=='Exchange'):?>
<script>
function renew_kurs()
{
	$.ajax({
								   type: "GET",
								   url: '/ajax/renew_kurs' ,
								   dataType: 'json', 
									cache:false,
									contentType: false,
									processData: false,
								  
								   success: function(data)
								   {
									  $.each( data  , function( index, value ) {
										   console.log( value.id+' '+  value.sum_to );
										   
										   $('#sum_to'+value.id).html(value.sum_to);
										   $('#status'+value.id).html(value.status);
										});
									      
								   }
						});
}
setInterval(renew_kurs,60000);
renew_kurs();
</script>	
<?endif;?>
 
</body>
</html>