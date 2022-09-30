							<?if ($outcome['id']==0):?>	
								<label for=""><?=l('Пояснение');?></label><br>
                                <input type="text" name="costum_text" id="costum_text" OnChange="copon_name($('#costum_text').val());" value="">
                                <br>
								<label for=""><?=l('Прогноз');?></label><br>
								<br><input type="text" name="costum_outcome" id="costum_outcome"  OnChange="cupon_tip();"  value="">
                                
							<?else:?>
								<label for=""><?=l('Пояснение');?></label><br>
                                <input type="text" name="costum_text" id="costum_text" OnChange="copon_name($('#costum_text').val());" value="">
                                <br>
								<div class="prog_edit-swich clear_fix">
                                    <select name="market"  OnChange="cupon_tip();" id="market">   
										<option value="2"><?=l('Игра');?></option> 
										<?if ($outcome['markets']>1):?><option value="3"><?=l('1-й таймa');?></option> <?endif;?>
										<?if ($outcome['markets']>2):?><option value="3"><?=l('2-й тайм');?></option> <?endif;?>
									</select>
                                </div>
								<?$handicaps=get_object_vars(json_decode($outcome['mixed_names']));
								ksort($handicaps);
								?>
								
								<?if (count($handicaps)>1):?>
								<div class="prog_edit-swich clear_fix">
                                    <select name="handicap_val"  OnChange="cupon_tip();"  id="handicap_val">   
										<?foreach ($handicaps as $k=>$v):?>
										<option value="<?=$k?>"><?=$v?></option> 
										<?endforeach;?>
									</select>
                                </div>
								<?else:?>
								<input type="hidden" id="handicap_val" name="handicap_val" value="0">
								<?endif;?>
								<?$team_val=get_object_vars(json_decode($outcome['team_val']));?>
								<?if (count($team_val)>1):?>
								<div class="prog_edit-swich clear_fix">
                                    <select name="team"  OnChange="cupon_tip();"  id="team">   
										<?foreach ($team_val as $k=>$v):?>
										<option value="<?=$k?>"><?=$v?></option> 
										<?endforeach;?>
									</select>
                                </div>
								<?else:?>
								<input type="hidden" name="team" id="team" value="0">
								<?endif;?>
							<?endif;?>	