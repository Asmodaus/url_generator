<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
<section class="card">
			<div class="card-header">
				<span class="cat__core__title">
					<strong>Партнеры апликаций</strong>
				</span>
			</div>
<div class="card-block">	
      <div class="box-body">
			  <br>
				<form action='?' id='form1' method="get">
					<?if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
					if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d');
					?>
					<input type="date" id="time1" name="time1" value="<?=date('Y-m-d',strtotime($_GET['time1']))?>">
					<input type="date" id="time2" name="time2" value="<?=date('Y-m-d',strtotime($_GET['time2']))?>">
					<button type="submit" >Применить</button>
					
					
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d')?>');$('#time2').val('<?=date('Y-m-d')?>');">Сегодня</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600)?>');$('#time2').val('<?=date('Y-m-d',time()-24*3600)?>');">Вчера</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*7)?>');$('#time2').val('<?=date('Y-m-d',time())?>');">Неделя</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*14)?>');$('#time2').val('<?=date('Y-m-d',time()-24*3600*7)?>');">Прошлая</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*30)?>');$('#time2').val('<?=date('Y-m-d',time())?>');">30 дней</a>
				</form>
			 
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
			<div id="example1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
			<div class="row">
             <div class="col-sm-12">
            
              <table class="table table-hover <?if (strpos(  $model_name,'Transactions')!==false ):?>table-responsive<?endif;?> nowrap dataTable dtr-inline" id="example1" width="100%" role="grid" aria-describedby="example1_info">
          <thead class="thead-default">
				<tr role="row">
					<th>ID</th>
					<th>Название апликации</th>
					<th>Подтвержденных пользователей</th>
					<th>Кол-во заказов</th>
					<th>Сумма заказов EUR</th>
					<th>Заработал EUR</th>
					<th>Комиссия %</th>
                </tr>
                </thead>
                <tbody>
                <?
				$time1=strtotime($_GET['time1']);
				$time2=strtotime($_GET['time2']);
				
				foreach ($this->db->query("SELECT u.*, usapp.meta_value app_name_partner, 
				COUNT(e.id) count, SUM(IFNULL(trans.meta_value,0)) profit, SUM(e.sum) sum FROM users u 
				,   exchange e , meta_value trans, transactions t,  meta_value usapp  
				WHERE   usapp.id=u.id AND usapp.meta_key='app_name_partner' AND usapp.table='users'
				AND  e.app_name=usapp.meta_value AND e.update_time>'$time1' AND e.update_time<'$time2' 
				AND e.status=2  AND t.ex_id=e.id AND 
				trans.id=t.id AND trans.meta_key='profit_partner' AND trans.table='transactions'

				GROUP BY u.id ORDER BY u.id DESC  ")->result_array() as $row):
				
				$row2=$this->db->query("SELECT   COUNT(id) count   FROM exchange WHERE status='-3' AND  app_name='{$row['app_name_partner']}'    AND  create_time>'$time1' AND  create_time<'$time2'  ")->row_array();
							$Us = new Users($this,$row['id']);	
				?>
                <tr>
					 
					<td title="<?=$row['id']?>"><?=$row['id']?></td>
					<td title="<?=$row['name']?>"><?=$row['name']?> <?=$row['email']?></td>
					<td title="<?=$row2['count']?>"><?=$row2['count']?></td>
					<td title="<?=$row['count']?>"><?=$row['count']?></td>
					<td title="<?=$row['sum']?>"><?=$row['sum']?></td>
					<td title="<?=$row['profit']?>"><?=$row['profit']?></td>
					<td title="<?=$Us->app_com?>"><?=$Us->app_com?></td>
				</tr>
				<?endforeach;?> 
				</tbody>
                <tfoot>
				<tr>
					<th>ID</th>
					<th>Название апликации</th>
					<th>Подтвержденных пользователей</th>
					<th>Кол-во заказов</th>
					<th>Сумма заказов EUR</th>
					<th>Заработал EUR</th>
				</tr>
				</tfoot>
              </table>
            </div></div>
        
        </div>
    </div>
</section>

<?include('footer2.php');?>
	  <script>
  $(function () {
    $("#table_edit").DataTable( {
        "order": [[ 0, "desc" ]]
    });
    
  });
</script>
<!-- DataTables -->
<script src="<?=$path?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$path?>plugins/datatables/dataTables.bootstrap.min.js"></script>
</body>
</html>