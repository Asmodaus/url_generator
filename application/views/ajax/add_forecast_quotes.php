  
                            <table>    
								<?if (!($Express->id>0 && $Express->get_count_events()<$Express->max_forecast)):?>
                                <thead>
                                    <tr>  
                                      <th colspan="2"><?=l('Контора');?></th>
									  <?foreach ($team_vals as $k=>$v):?>
                                      <th><?=l($v);?></th>
                                     <?endforeach;?>
                                    </tr>
                                </thead>   
								<?endif;?>
                                <tbody>
								<?if ($Express->id>0 && $Express->get_count_events()<$Express->max_forecast):?>
									<tr>
                                        <td colspan="2"><?=l('Выберите ставку');?></td>
										<?foreach ($team_vals as $k=>$v):?>
										    <td   class="activ_cell"  >
											<a class="quote_link" href="javascript:" OnClick="set_quote(this,'<?=l('-');?>','0','1','<?=(new Forecast_Events($this))->get_cupon($outcome,$_POST['handicap'],$_POST['market'],$k);?>','<?=$k?>');" ><?=$v?></a></td>
										<?endforeach;?>    
									</tr> 
								<?else:?>
								<? 
								foreach ($quotes as $bookmaker_id => $bookmaker): ?>
                                    <tr>
                                        <td><?=$bookmaker['bookmaker']['name']?></td>
                                        <td><img src="/upload/<?=$bookmaker['bookmaker']['img']?>"></td>
										<?foreach ($team_vals as $k=>$v):?>
										    <td  <?if ($max_vals[$k]==$bookmaker['quote'][$k]) echo 'class="activ_cell"';?> >
											<a class="quote_link" href="javascript:" OnClick="set_quote(this,'<?=$bookmaker['bookmaker']['name']?>','<?=$bookmaker_id?>','<?=$bookmaker['quote'][$k]?>','<?=(new Forecast_Events($this))->get_cupon($outcome,$_POST['handicap'],$_POST['market'],$k);?>','<?=$k?>');" ><?=$bookmaker['quote'][$k]?></a></td>
										<?endforeach;?>                                 
                                    </tr> 
                                <?endforeach;?>
								<?endif;?>
                                </tbody>
                            </table>
                        