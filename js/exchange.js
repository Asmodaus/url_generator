	  
let excnange_id;
let key;
				 
				 function set_rate(class_name,key='')
				 {
					 $.ajax({
								  type: "GET",
								  url: '/ajax/change_trans3'+'?from='+$('#from').val()+'&to='+$('#to').val()+'&'+class_name+'_sum='+$('#'+class_name+'_sum'+key).val(),
								  dataType: 'json', 
								   cache:false,
								   contentType: false,
								   processData: false,
								 
								  success: function(data)
								  {
									if (class_name=='to')
										$('#from_sum'+key).val(data.from_sum); 
									else
										$('#to_sum'+key).val(data.to_sum); 
									 
								  }
					   });
				 }
				 
				 function step1()
				 {
					var min = $('#valut_from_'+$('#from').val()).find('.min').html();
					$('.min_from').html('Минимальная сумма: '+min);
					min=parseFloat(min);

					if ($('#from').val()==$('#to').val()) $('#exchange_result').html('Выберите разные направления');
					else if (min>$('#from_sum').val()) $('#exchange_result').html('Минимальная сумма: '+min);
					else 
					{
						$('#right_block_faq').hide();
						$('#right_block_ins').removeClass('d-none');
						$('#step1').hide();
						$('#step2').removeClass('d-none');
						$('#st2').addClass('active');
						$('#st1').addClass('done');
						$('#st1').removeClass('active');
						$('.valut_from.active').clone().appendTo('#from_select');
						$('.valut_to.active').clone().appendTo('#to_select');
						$('#to_sum_2').val($('#to_sum').val()); 
						$('#from_sum_2').val($('#from_sum').val()); 
						$('#ticker_to_2').html($('#ticker_to').html());
						$('#ticker_from_2').html($('#ticker_from').html());

						
						if ($('.valut_to.active').hasClass('type1'))
							$('#to_crypto_wallet').remove();
						else  
							$('.to_card_wallet').remove();
						

						if ($('.valut_to.active').hasClass('type0') && $('.valut_from.active').hasClass('type0'))
						{
							$('.change_card').remove();
						}
						else 
						{
							$('.change_crypto').remove();
						}
						
					}
					

				 }

				 function cancel()
				 {
					window.location.href="?cancel="+excnange_id;
				 }
				 
				 function step2(ex_id,nk)
				 {
					  excnange_id=ex_id;
					  key=nk;
					 $('#st3').addClass('active');
					 $('#st2').addClass('done');
					 $('#st2').removeClass('active');

					 $('#to_sum_3').html($('#to_sum_2').val()); 
					$('#from_sum_3').html($('#from_sum_2').val()); 
					$('#ticker_to_3').html($('#ticker_to').html());
					$('#ticker_from_3').html($('#ticker_from').html());
					if ($('#wallet1')) $('#wallet3').html($('#wallet1').val());
					else if ($('#wallet2')) $('#wallet3').html($('#wallet2').val());

					$('#step2').hide();
					$('#step3').removeClass('d-none');

				 }
				 
				 function step3()
				 {
					window.location.href="/exchange/"+excnange_id+"/"+key;
				 }
				
				
				  function set_type(type,class_name)
				  {
					   $('.type_'+class_name).removeClass('active');
					   $('#type_'+class_name+'_'+type).addClass('active');
					   $('.valut_'+class_name).removeClass('d-none');
					   $('.valut_'+class_name).addClass('d-none');
					   $('.valut_'+class_name+'.type'+type).removeClass('d-none');
				  }

			   function setvalut(class_name,id)
				 { 
					 $('#'+class_name).val(id);
					 $('.valut_'+class_name).removeClass('active');
					 $('#valut_'+class_name+'_'+id).addClass('active'); 

					var ticker =  $('#valut_'+class_name+'_'+id).find('.ticker').html();
					$('#ticker_'+class_name).html(ticker+':');
					var min = $('#valut_'+class_name+'_'+id).find('.min').html();
					$('.min_'+class_name).html('Минимальная сумма: '+min);
					min=parseFloat(min);
					if (min>$('#from_sum').val()) $('#from_sum').val(min);
					 
					set_rate(class_name);
				 }

				 function reverse()
				 {
					   var id1 = $('#from').val();
					   var id2 = $('#to').val();
					   var sum1= $('#from_sum').val();
					 	 var sum2= $('#to_sum').val();

					   setvalut('to',id1);
					   setvalut('from',id2);
					   $('#from_sum').val(sum2);
					   set_rate('from');
					  
				 }

				 function copy(selector)
				 {
					$(selector).select();
					document.execCommand('copy');
				 }
			
setvalut('from',47); 	 
setvalut('to',46);