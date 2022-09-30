   
                            <table>    
								 
                                <thead>
                                    <tr>  
                                      <th ><?=l('Контора');?></th> 
                                      <th><?=l('Суммарная катировка');?></th> 
                                    </tr>
                                </thead>   
							 
                                <tbody> 
								<? 
								foreach ($bookings as $bookmaker_id => $row): ?>
                                    <tr>
                                        <td><?=$bookmakers[$bookmaker_id]?></td>
                                       
										<td <?if ($max==$row['sum']) echo 'class="activ_cell"';?> >
										<a  class="quote_link <?if ($max==$row['sum']) echo 'activ';?>" OnClick="<?foreach ($row as $quote_id=>$quote):?>$('#quote_<?=$quote_id?>').html('<?=number_format2($quote,2)?>');<?endforeach;?>$('.quote_link.activ').removeClass('activ');$(this).addClass('activ');$('#bookmaker_id').val('<?=$bookmaker_id?>');" href="javascript:"   ><?=number_format2($row['sum'],2)?></a></td>
										                           
                                    </tr> 
									<?if ($max==$row['sum']):?>
									<script><?foreach ($row as $quote_id=>$quote):?>$('#quote_<?=$quote_id?>').html('<?=number_format2($quote,2)?>');<?endforeach;?>$('#bookmaker_id').val('<?=$bookmaker_id?>');</script>
									<?endif;?>
                                <?endforeach;?> 
                                </tbody>
                            </table>
                        <form  action="javascript:void(null);" method="post" OnSubmit="ajax_post('save_express',this,'#res-add_forecast');">
							   <select disabled name="delivery_id" required id="delivery_id">
											<?foreach ((new Delivery($this))->get_all(999,0,'name','asc',array('user_id'=>$user->id)) as $delivery):?>
											<option <?if ($_COOKIE['default_delivery']==$delivery['id']) echo 'selected';?>  value="<?=$delivery['id']?>"><?=$delivery['name'];?></option>
											<?endforeach;?>
									   </select>
							 <input type="checkbox" checked value="1" id="checkbox_delivery" OnClick="checkboxdelivery();"/>
							<br>
							
							<input type="hidden" value="" id="bookmaker_id" name="bookmaker_id">
							<label for=""><?=l('Ставка');?>: </label>
							<input type="text" required class="small" value="<?=(new Delivery($this,(int)$_COOKIE['default_delivery']))->settings_rates;?>"  name="rate"> %
						<br>
							<button class="bt-norm"><?=l('Завершить создание экспресса');?></button>
						</form>