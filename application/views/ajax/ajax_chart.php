 <?
 
						
						$row = $this->db->query("SELECT * FROM valut_rates_history WHERE valut1='{$valut['id']}' AND valut2='{$user->valut_id}' AND time>='".(time()-$key_time)."' ORDER BY time ASC LIMIT 1  ")->row_array();
						 if ($_POST['buy']==1)
						 {
							 $rate=1/(new Vaucher($this))->get_curs($user->valut_id,$valut['id']);
							 $row['rate']*=(1+vars('rate')/100); 
						 }
						 else {
							 $rate=(new Vaucher($this))->get_curs($valut['id'],$user->valut_id);
							 $row['rate']*=(1-vars('rate')/100); 
						 }
						
						
						?>
						<div class="row info-kurs">
                            <div class="col-sm-4 text-center">
                              <h3><span></span> <?=number_format($rate,2)?></h3>
                              <strong><?=$valut['name']?> <?=l('PRICE');?></strong>
                            </div>
							 
                            <div class="col-sm-4 text-center">
                              <h3><?if ($rate-$row['rate']>=0) echo '<span class="text-success">+</span>'; else echo '<span class="text-danger">-</span>';?> <?=number_format(abs($rate-$row['rate']),2)?></h3>
                              <strong><?=l('SINCE LAST '.$dt);?> (<?=$user_valut['name']?>)</strong>
                            </div>
                            <div class="col-sm-4 text-center">
                              <h3><?if ($rate-$row['rate']>=0) echo '<span class="text-success">+</span>'; else echo '<span class="text-danger">-</span>';?><?=number_format(abs(($rate-$row['rate'])/$rate*100),2)?>%</h3>
                              <strong><?=l('SINCE LAST '.$dt);?> (%)</strong>
                            </div>
							 
                          </div>
                          <div class="holder-chart">
                            <div id="chart<?=$valut['id']?>_<?=$i?>">
                                <svg></svg>
                            </div>
                          </div>
							<script>
			

    // Wrapping in nv.addGraph allows for '0 timeout render', stores rendered charts in nv.graphs,
    // and may do more in the future... it's NOT required
    nv.addGraph(function() {
      var  chart = nv.models.lineChart()
           .useInteractiveGuideline(true)
            .x(function(d) { return d[0] })
            .y(function(d) { return d[1]  })
             ;
        chart.dispatch.on('renderEnd', function() {
            console.log('render complete: cumulative line with guide line');
        });

        chart.xAxis.tickFormat(function(d) {
			<?if ($key_time<4000):?>
            return d3.time.format('%H:%M')(new Date(d))
			<?elseif ($key_time<3600*24*2):?>
			 return d3.time.format('%H:%M')(new Date(d))
			<?else:?>
			 return d3.time.format('%m/%d/%y')(new Date(d))
			<?endif;?>
        });

        // chart.yAxis.tickFormat(d3.format(',.2f'));
		 
		 chart.yAxis
          .tickFormat(function(d) { return  d3.format(',.2f')(d) });

         d3.select('#chart<?=$valut['id']?>_<?=$i?> svg')
								.datum(cumulativeTestData<?=$valut['id']?>_<?=$i?>())
								.call(chart);

        //TODO: Figure out a good way to do this automatically
        nv.utils.windowResize(chart.update);

        chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });
        chart.state.dispatch.on('change', function(state){
            nv.log('state', JSON.stringify(state));
        });

        return chart;
    });

    

    function cumulativeTestData<?=$valut['id']?>_<?=$i?>() {
        return [
			<?foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0,'id !='=>7)) as $valut2):?>
            {
                key: "<?=$valut2['name']?>",
                values: [
					<?foreach ($this->db->query("SELECT * FROM valut_rates_history WHERE valut1='{$valut['id']}' AND valut2='{$valut2['id']}' AND time>='".(time()-$key_time)."' ORDER BY time ASC ")->result_array() as $row):?>
					[ <?=$row['time']?>000 , <? if ($_POST['buy']==1) echo $row['rate']*(1+vars('rate')/100); else   echo $row['rate']*(1-vars('rate')/100);?>] , 
					<?endforeach;?>
				  ]
                ,mean: 10
            },
            <?endforeach;?>
        ];
    }


			</script>
		 
			
			