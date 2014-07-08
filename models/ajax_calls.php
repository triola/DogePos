<script type="text/javascript">

var obj;
		
		function ajaxRequest(url,command) {
		  // native  object
		
		  if (window.XMLHttpRequest) {
		    // obtain new object
		    obj = new XMLHttpRequest();
		    // set the callback function
		     if (command == "getAddress"){
		     	 obj.onreadystatechange = getAddress;
		      } else if (command == "checkPayment"){
		     	 obj.onreadystatechange = checkPayment;
		      } else if (command == "getConversion"){
		     	 obj.onreadystatechange = getConversion;

		      }

		    // we will do a GET with the url; "true" for asynch
		    obj.open("GET", url, true);
		    // null for GET with native object
		    obj.send(null);
		  // IE/Windows ActiveX object
		  } else if (window.ActiveXObject) {
		    obj = new ActiveXObject("Microsoft.XMLHTTP");
		    if (obj) {
		      
		      if (command == "getAddress"){
		     	 obj.onreadystatechange = getAddress;
		      } else if (command == "checkPayment"){
		     	 obj.onreadystatechange = checkPayment;
		      } else if (command == "getConversion"){
		     	 obj.onreadystatechange = getConversion;
		      }
		      obj.open("GET", url, true);
		      // don't send null for ActiveX
		      obj.send();
		    }
		  } else {
		    alert("Your browser does not support AJAX");
		  }
		}
		
		
		
		function getAddress() {
		    // 4 means the response has been returned and ready to be processed
		    if (obj.readyState == 4) {
		        // 200 means "OK"
		        if (obj.status == 200) {
		            // process whatever has been sent back and put it in #results
		            //use if we want to return something from the ajax script --->   jQuery('#results').html(obj.responseText);
		            account = jQuery.parseJSON ( obj.responseText );
		            
		            jQuery(".textaddress").text(account.address);
		            jQuery(".addressqr").prepend("<div id='QRcode' class='hidden'></div>");
		            address = account.address;
		            
			        jQuery('#QRcode').qrcode({
								text : address
					});     
		        
		        // anything else means a problem
		        } else {
		            alert("There was a problem in the returned data:processAddress\n");     
		            alert(obj.responseText);
		
		        }
		    }
		}
		
		function getConversion() {
		    // 4 means the response has been returned and ready to be processed
		    if (obj.readyState == 4) {
		        // 200 means "OK"
		        if (obj.status == 200) {
		            // process whatever has been sent back and put it in #results
		            //use if we want to return something from the ajax script --->   jQuery('#results').html(obj.responseText);
		            amount = obj.responseText;
		            
		            jQuery(".conversion").text(amount);
					ajaxReady = 1;
		        
		        // anything else means a problem
		        } else {
		            alert("There was a problem in the returned data:processAddress\n");     
		            alert(obj.responseText);
		
		        }
		    }
		}


		function getAddress2(data) {
		   account = jQuery.parseJSON ( data );
		            
		            jQuery(".textaddress").text(account.address);
		            jQuery(".addressqr").prepend("<div id='QRcode' class='hidden'></div>");
		            address = account.address;
		            
			        jQuery('#QRcode').qrcode({
								text : address
					});    
					
					return address; 
		        
		}
		
		
		function getConversion2(amount) {
			amount = Math.ceil(amount);
		   jQuery(".conversion").text(amount);
		   
		   return amount;
		}
		
		function getBTC(amount) {
			amount = amount * 100000;
			amount = Math.ceil(amount);
			amount = amount / 100000;
		   jQuery(".conversion").text(amount);
		   
		   return amount;
		}

</script>
		