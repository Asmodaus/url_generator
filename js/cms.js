	    
				 function select(table,val,selector )
				 {
					 $.ajax({
								  type: "GET",
								  url: '/ajax/select'+'?table='+table+'&val='+val,
								  dataType: 'html', 
								   cache:false,
								   contentType: false,
								   processData: false,
								 
								  success: function(data)
								  {
										$(selector).html(data); 
										$(selector).OnChange();
								  }
					   });
				 }
				  

				 function copy(selector)
				 {
					$(selector).select();
					document.execCommand('copy');
				 }
			 