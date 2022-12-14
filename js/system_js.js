	function ajax(file,post,div)
    {
		if (file=='valut_chart') {
			$(div).html('<img src="/js/loading.gif" >');  
		}
       $.post('/ajax/'+file,
					post , 
				function(data, textStatus){ 
					$(div).html(data);  
				},
					"html" // "xml", "script", "json", "jsonp", "text"
			);
    }
	
	function ajax_post(file,form_id,div)
    {
		$('select').removeAttr('disabled');
		$(div).html('<img src="/js/loading.gif" >');  
       $.ajax({
				   type: "POST",
				   url: '/ajax/'+file,
				    cache:false,
					contentType: false,
					processData: false,
				   data: new FormData(form_id), // serializes the form's elements.
				   success: function(data)
				   {
					    $(div).html(data);  
				   }
		});
    }
	
	function copy(selector_id) {
		// Get the text field
		var copyText = document.getElementById(selector_id);
	  
		// Select the text field
		copyText.select();
		copyText.setSelectionRange(0, 99999); // For mobile devices
	  
		 // Copy the text inside the text field
		

		if (navigator.clipboard && window.isSecureContext) {
			// navigator clipboard api method'
			navigator.clipboard.writeText(copyText.value).then(function() { // Копируем текст в буффер обмена
			console.log(copyText.value);
					}, function() {
						console.log(copyText);
					});
		} else {
			// text area method
			let textArea = document.createElement("textarea");
			textArea.value = copyText.value;
			// make the textarea out of viewport
			textArea.style.position = "fixed";
			textArea.style.left = "-999999px";
			textArea.style.top = "-999999px";
			document.body.appendChild(textArea);
			textArea.focus();
			textArea.select();
			return new Promise((res, rej) => {
				// here the magic happens
				document.execCommand('copy') ? res() : rej();
				textArea.remove();
			});
		}
				
	   
	  }
	