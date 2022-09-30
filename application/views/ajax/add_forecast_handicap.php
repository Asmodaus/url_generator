 
                            <div class="prog_creat-head">   
                                <?=l('Тип');?>: <b><?=$outcome['name'];?></b> - <?=l('Период');?>: <b><?=$market?></b> - <?=l('Актуально');?>: <b><?=l('еще');?> 3 <?=l('мин');?></b>.
                            </div>
							<?
							
							$mixed_names=get_object_vars((json_decode($outcome['mixed_names'])));
							ksort($mixed_names);
							if (count($mixed_names)>1):?>
                             <h3><?=l('Выберите рынок');?></h3> 
                            <div class="prog_creat-swich clear_fix"> 
								<?foreach ($mixed_names as $key=>$val): 
								$quotes=$Event->get_quote_list($outcome_id,$market_id,$key);
								 
								foreach ($quotes as $k=>$v) if (!in_array($k,$bookings)) unset($quotes[$k]);
								if (count($quotes)>0):
								?>
										<button <?if (!isset($activ)) {$activ=1;echo 'id="activ_handicap"';}?> class="handicap_button" OnClick="return set_handicap('<?=$key?>',this );"><?=$val?></button>
								<?
								endif;
								endforeach;?>
                            </div>
							<script>
							set_handicap($('#activ_handicap').html(), '#activ_handicap' );
							</script>
							<?else:?>
							<script>
							set_handicap('0', '#activ_handicap' );
							</script>
							<?endif;?>  
							
							