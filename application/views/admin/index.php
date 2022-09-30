<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('header2.php'); 
?> 


<!-- START: dashboard -->
	<nav class="cat__core__top-sidebar cat__core__top-sidebar--bg">
		<span class="cat__core__title d-block mb-2">
			<span class="text-muted">Dashboard</span>
		</span>
    </nav>
    <section class="row">
    <? /*
    <div class="col-lg-8">
        <section class="card">
            <div class="card-header">
				<div class="mb-5">
                    <div class="nav-tabs-vertical">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#home3" role="tab" aria-expanded="true">Заказы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#profile3" role="tab" aria-expanded="false">Суммы заказов</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#messages3" role="tab" aria-expanded="false">Доход</a>
                            </li>
							
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home3" role="tabcard" aria-expanded="true">
								<div class="row">
									<div class="col-lg-12">
										<div class="line"></div>
									</div>
								</div>
                            </div>
                            <div class="tab-pane" id="profile3" role="tabcard" aria-expanded="false">
                                <div class="row">
									<div class="col-lg-12">
										<div class="line2"></div>
									</div>
								</div>
                            </div>
                            <div class="tab-pane" id="messages3" role="tabcard" aria-expanded="false">
								<div class="row">
									<div class="col-lg-12">
										<div class="line3"></div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </section>
    </div>
    */ ?>
    <div class="col-lg-4">
        <section class="card">
            <div class="card-block">
            <center><h4>Заказы</h4></center>
                <div class="chart-pie-chart"></div>
            </div>
        </section>
    </div>
	</section>
    <?/*
    <section class="row">
    <div class="col-lg-4">
        <section class="card">
            <div class="card-header">
                <span class="cat__core__title">
                    <strong>Заказы</strong>
                </span>
            </div>
            <div class="card-block">
            <div class="mb-5">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">Сегодня</th>
                            <td>
                                <?=$profit1?> <span class="text-<?if($profit1_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($profit1_mod,2)?>%)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Вчера</th>
                            <td>
                                <?=$profit2?> <span class="text-<?if($profit2_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($profit2_mod,2)?>%)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">7 дней</th>
                            <td>
                                <?=$profit3?> <span class="text-<?if($profit3_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($profit3_mod,2)?>%)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">30 дней</th>
                            <td>
                                <?=$profit4?> <span class="text-<?if($profit4_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($profit4_mod,2)?>%)</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-4">
        <section class="card">
            <div class="card-header">
                <span class="cat__core__title">
                    <center><strong>Сумма заказов</strong></center>
                </span>
            </div>
			<div class="card-block">
            <div class="mb-5">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row">Сегодня EUR</th>
                            <td>
                                <?=number_format($sum_profit1,2)?> <span class="text-<?if($sum_profit1_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($sum_profit1_mod,2)?>%)</span>
                            </td>
                        </tr> 
                        <tr>
                            <th scope="row">Вчера EUR</th>
                            <td>
                               <?=number_format($sum_profit2,2)?> <span class="text-<?if($sum_profit2_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($sum_profit2_mod,2)?>%)</span>
                            </td>
                        </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-4">
        <section class="card">
            <div class="card-header">
                <span class="cat__core__title">
                    <center><strong>Доход</strong></center>
                </span>
            </div>
			<div class="card-block">
            <div class="mb-5">
                    <table class="table table-striped">
                        <tbody>
                         <tr>
                            <th scope="row">Сегодня EUR</th>
                            <td>
                                <?=number_format($p_profit1,2)?> <span class="text-<?if($p_profit1_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($p_profit1_mod,2)?>%)</span>
                            </td>
                        </tr> 
                        <tr>
                            <th scope="row">Вчера EUR</th>
                            <td>
                               <?=number_format($p_profit2,2)?> <span class="text-<?if($p_profit2_mod<0) echo'danger'; else echo 'success';?>">(<?=number_format($p_profit2_mod,2)?>%)</span>
                            </td>
                        </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</section>
*/?>
    <div class="row">
            <div class="col-lg-4">
        <div class="cat__core__widget">
            <div class="cat__core__step cat__core__step--success">
                <span class="cat__core__step__digit">
                    <i class="icmn-price-tags"><!-- --></i>
                </span>
                <div class="cat__core__step__desc">
                    <span class="cat__core__step__title">Выполненные заказы</span>
                    <p>Всего: <?=$count_ex?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="cat__core__widget">
            <div class="cat__core__step cat__core__step--primary">
                <span class="cat__core__step__digit">
                    <i class="icmn-users"><!-- --></i>
                </span>
                <div class="cat__core__step__desc">
                    <span class="cat__core__step__title">Пользователей</span>
                    <p>Всего: <?=$count_us?></p>
                </div>
            </div>
        </div>
    </div>
    <?/*
    <div class="col-lg-4">
        <div class="cat__core__widget">
            <div class="cat__core__step cat__core__step--info">
                <span class="cat__core__step__digit">
                    <i class="icmn-users"><!-- --></i>
                </span>
                <div class="cat__core__step__desc">
                    <span class="cat__core__step__title">Пользователи прошедшие проверку</span>
                    <p>Всего: <?=$count_conf?></p>
                </div>
            </div>
        </div>
    </div>   
    */?>
    </div>
    <section class="row">
		<?foreach ($this->db->query("SELECT r.rate, v1.name name1, v2.name name2, v2.number_format FROM valut v1, valut v2 , valut_rates r WHERE r.valut1=v1.id AND r.valut2=v2.id ")->result_array() as $row):?>
               <div class="col-lg-2">
					<section class="card">
						<div class="card-header">
							<span class="cat__core__title">
								<center><strong><?=$row['name1']?>/<?=$row['name2']?></strong></center>
							</span>
						</div>
						<div class="card-block">
							<center><h4><?=number_format($row['rate'],$row['number_format'])?></h4></center>
						</div>
					</section>
				</div> 
        <?endforeach;?> 
	</section>


<!-- START: page scripts -->
<script>
    $(function () {

        var colors = {
            _primary: '#01a8fe',
            _default: '#acb7bf',
            _success: '#46be8a',
            _danger: '#fb434a'
        };
		<?
		$res = $this->db->query("SELECT COUNT(id) as count, DATE_FORMAT(FROM_UNIXTIME(update_time), '%Y.%m.%d') as day FROM exchange e WHERE status>=1 $addsql AND update_time>'".(time()-30*24*3600)."' GROUP BY day ORDER BY day ASC ")->result_array();
		$data=[];
		foreach ($res as $v) $data[$v['day']]=$v['count'];
		
		$res = $this->db->query("SELECT SUM(sum) as count, DATE_FORMAT(FROM_UNIXTIME(update_time), '%Y.%m.%d') as day FROM exchange e WHERE status>=1 $addsql AND update_time>'".(time()-30*24*3600)."' GROUP BY day ORDER BY day ASC ")->result_array();
		$data2=[];
		foreach ($res as $v) $data2[$v['day']]=$v['count'];
		
		$res = $this->db->query("SELECT SUM(profit) as count, DATE_FORMAT(FROM_UNIXTIME(update_time), '%Y.%m.%d') as day FROM exchange e WHERE status>=1 $addsql AND update_time>'".(time()-30*24*3600)."' GROUP BY day ORDER BY day ASC ")->result_array();
		$data3=[];
		foreach ($res as $v) $data3[$v['day']]=$v['count'];
		?>
		 $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            chart_change();
        });

		function chart_change()
		{
			chart1.update();
            chart2.update();
            chart3.update();
			 
		}
		
		
        var chart1 = new Chartist.Line(".line", {  
				<?
				$lb=[];foreach ($data as $k=>$v) $lb[]="'".$k."'";
				?>
				labels: [<?=implode(',',$lb)?>],
                series: [
                    [ <?=implode(',',$data)?>]
                ]
            }, {
            fullWidth: !0,
            chartPadding: {
                right: 15,
                left: -15
            },
            low: 0,
            showArea: true,
            plugins: [
                Chartist.plugins.tooltip()
            ]
        }); 
		var chart2 = new Chartist.Line(".line2", {  
               <?
				$lb=[];foreach ($data2 as $k=>$v) $lb[]="'".$k."'";
				?>
				labels: [<?=implode(',',$lb)?>],
                series: [
                    [ <?=implode(',',$data2)?>]
                ]
             }, {
            fullWidth: !0,
            chartPadding: {
                right: 15,
                left: -15
            },
            low: 0,
            showArea: true,
            plugins: [
                Chartist.plugins.tooltip()
            ]
        }); 
		var chart3 = new Chartist.Line(".line3", {  
                <?
				$lb=[];foreach ($data3 as $k=>$v) $lb[]="'".$k."'";
				?>
				labels: [<?=implode(',',$lb)?>],
                series: [
                    [ <?=implode(',',$data3)?>]
                ]
            }, {
            fullWidth: !0,
            chartPadding: {
                right: 15,
                left: -15
            },
            low: 0,
            showArea: true,
            plugins: [
                Chartist.plugins.tooltip()
            ]
        }); 
		<?
        /*
		$row1 = $this->db->query("SELECT COUNT(id) as count  FROM transactions LEFT JOIN exchange e ON e.id=transactions.ex_id WHERE time>'".(time()-30*24*3600)."' $addsql   ")->row_array();
		$row2 = $this->db->query("SELECT COUNT(id) as count  FROM transactions_sepa LEFT JOIN exchange e ON e.id=transactions_sepa.ex_id  WHERE time>'".(time()-30*24*3600)."'   $addsql ")->row_array();
		$row3 = $this->db->query("SELECT COUNT(id) as count  FROM transactions_cash LEFT JOIN exchange e ON e.id=transactions_cash.ex_id  WHERE time>'".(time()-30*24*3600)."'  $addsql  ")->row_array();
		*/
		
		?>
        c3.generate({
            bindto: '.chart-pie-chart',
            data: {
                columns: [
                    ['Bank card', <?=$row1['count']?>],
                    ['SEPA', <?=$row2['count']?>],
                    ['Cash', <?=$row3['count']?>]
                ],
                type : 'pie'
            },
            color: {
                pattern: [colors._primary, colors._success, colors._danger]
            }
        });
        
    });
</script>
  
  
			  
       
	<?include('footer2.php');?>
<script src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(function(){
    $('textarea').each(function(e){
        CKEDITOR.replace( this.id);
    });
});
</script>
</body>
</html>