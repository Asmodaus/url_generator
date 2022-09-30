<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php');
?> 
<section class="card">
			<div class="card-header">
				<span class="cat__core__title">
					<strong>Рефералы</strong>
				</span>
			</div>
<div class="card-block">	
      <div class="box-body">
			  <br>
				<form action='?' id='form1' method="get">
					<?
					date_default_timezone_set('UTC');
					
					if ($_GET['time1']==0) $_GET['time1']=date('Y-m-d',time()-30*24*3600);
					if ($_GET['time2']==0) $_GET['time2']=date('Y-m-d',time()+23*3600+3599);
					?>
					<input type="date" id="time1" name="time1" value="<?=date('Y-m-d',strtotime($_GET['time1']))?>">
					<input type="date" id="time2" name="time2" value="<?=date('Y-m-d')?>">
					<button type="submit" >Применить</button>
					
					
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d')?>');$('#time2').val('<?=date('Y-m-d',time()+23*3600+3599)?>');">Сегодня</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600)?>');$('#time2').val('<?=date('Y-m-d')?>');">Вчера</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*7)?>');$('#time2').val('<?=date('Y-m-d',time())?>');">Неделя</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*14)?>');$('#time2').val('<?=date('Y-m-d',time()-24*3600*7)?>');">Прошлая</a> | 
					<a href="javascript:" OnClick="$('#time1').val('<?=date('Y-m-d',time()-24*3600*30)?>');$('#time2').val('<?=date('Y-m-d',time()+23*3600+3599)?>');">30 дней</a>
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
					<th>Пользователь</th>
					<th>Кол-во сделок</th>
					<th>Заработал USD</th>
					<th>Заработал EUR</th>
                </tr>
                </thead>
                <tbody>
				<?
				$time1=strtotime($_GET['time1']);
				$time2=strtotime($_GET['time2']);
			
                //echo strtotime('+1 day');
				//echo "<br>".$time1;
				//echo "<br>".$time2;
				
				
				foreach ($this->db->query("SELECT u.*, COUNT(u2.id) count, SUM(IFNULL(e.referal_profit,0)) eur, SUM(IFNULL(e2.referal_profit,0)) usd FROM users u , users u2 LEFT JOIN exchange e ON e.user_id=u2.id AND e.status=2 AND e.update_time>='$time1' AND e.update_time<='$time2'     AND (e.from=2 OR e.to=2) LEFT JOIN exchange e2 ON e2.user_id=u2.id AND e2.status=2  AND e2.update_time>='$time1' AND e2.update_time<='$time2'    AND (e2.from=1 OR e2.to=1)
				WHERE u2.referal=u.id    GROUP BY u.id ORDER BY u.id DESC  ")->result_array() as $row):
				
				?>
                <tr>
				
					<td title="<?=$row['id']?>"><?=$row['id']?></td>
					<td title="<?=$row['name']?>"><?=$row['name']?> <?=$row['email']?></td>
					<td title="<?=$row['count']?>"><?=$row['count']?></td>
					<td title="<?=$row['usd']?>"><?=$row['usd']?></td>
					<td title="<?=$row['eur']?>"><?=$row['eur']?></td>
					
				</tr>
				<?endforeach;?> 
				</tbody>
                <tfoot>
				<tr>
					<th>ID</th>
					<th>Пользователь</th>
					<th>Кол-во сделок</th>
					<th>Заработал USD</th>
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