<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
require_once("models/ajax_calls.php");
?>

<div class='container container_12'>
	<div class="currency">
		<img src="images/bitcoin.png">
		<p class="supplemental">Converted Amount</p>
		<p class="converted">&#3647; <span class="btc"></span></p>
	</div>
	<div class="amount">
		<form method="post">
			<label for="dollars" class="symbol">$</label>
			<input type="number" name="dollars" id="dollars" class="dollars">
			<div class="calc">
				<div class="key">1</div>
				<div class="key">2</div>
				<div class="key">3</div>
				<div class="key">4</div>
				<div class="key">5</div>
				<div class="key">6</div>
				<div class="key">7</div>
				<div class="key">8</div>
				<div class="key">9</div>
				<div class="btnkey">del</div>
				<div class="key">0</div>
				<div class="key">.</div>
			</div>
			<input type="submit" id="submit" >
		</form>
	</div>
	<div class="transaction_container grid_10 push_1">
		<div class="instructions">Please send <span class="green"><span class="conversion"></span> BTC</span> to the address below:</div>
		<div class="box">
			<div class="textaddress"></div><br>
			<div class="addressqr"></div>
		</div>
		<div class="preloader"><img src="images/ajax-loader.gif"></div>
		<div class="verified offscreenbottom"></div>
		<a href="/demo-pos.php" class="new"><i class="fa fa-plus-circle"></i></a>
	</div>
</div>
	</div>
</div>
<div id='bottom'></div>
</div>
<?php include("footer.php");?>

<script type="text/javascript">

	
	jQuery(document).ready(function(){
		var address;
		
		//get address for this transaction
		var getaddress = $.ajax( '/models/get_address.php' + '?user=' + 2 + '&type=btc' );
			  getaddress.done(function(data) {
			  	address = getAddress2(data);
			  	//clear any stacked payments
			  	var clear = $.ajax( '/models/verify_btc.php' + '?address=' + address + '&user=' + 2 );
			  	clear.done(function(data){
				});
		 });
	
	
	
		<?php if (isMobile()) {?>
		jQuery('#dollars').focus();
		<?php } ?>
	
		//number pad jquery stuff
		 $('.key').click(function(event){
        var numBox = jQuery('#dollars');
        if(this.innerHTML == '0'){
            if (numBox.val().length > 0) {
                numBox.val(numBox.val() + this.innerHTML);
            }
        }
        else {
            numBox.val(numBox.val() + this.innerHTML);
        }
        jQuery('#dollars').trigger("keyup");		
        event.stopPropagation();
    });


    
    $('.btnkey').click(function(event){
        if(this.innerHTML == 'del'){
            var numBox = jQuery('#dollars');
            if(numBox.val().length > 0){
                numBox.val( numBox.val().substring(0, numBox.val().length - 1));
            }
        }
        else{
            document.getElementById('numBox').innerHTML = '';
        }
        jQuery('#dollars').trigger("keyup");
        event.stopPropagation();
    });
		
		jQuery('#dollars').keyup(function(){
			amount = jQuery(this).val();
			var tempconversion = $.ajax( '/models/get_btc_conversion.php' + '?amount=' + amount + '&currency=USD' )
				  .done(function(data) {
				  btc = getBTC(data);
				  jQuery('.converted .btc').text(btc);
				  });
		});
		
		
	
		jQuery('#submit').click(function(event){ //fetch search results whenever a key is pressed
		   	  var amount;
		   	  var btc;
		   	  
			  event.preventDefault();			
			  jQuery(".amount").addClass('offscreenright').fadeOut(600);
			  jQuery(".currency").addClass('offscreenleft').fadeOut(600);			  
			  jQuery("#dollars").blur();
			  amount = jQuery('#dollars').val();
			  
			  //fire first ajax call for conversion
              var conversion = $.ajax( '/models/get_btc_conversion.php' + '?amount=' + amount + '&currency=USD' )
				  .done(function(data) {
				  //when it returns done, process it...
				  btc = getBTC(data);

					    jQuery('.transaction_container').delay(500).fadeIn(500);
					    //and start checking...
					    autoUpdate();
				  })
				  .fail(function() {
				    alert( "error" );
				  })
				  


			  
			  function autoUpdate(){
				//update every 5 seconds
			    var payment = $.ajax( '/models/verify_btc.php' + '?address=' + address + '&user=' + 2 );
				payment.done(function(data){
					if (data >= btc){
						jQuery ('.verified').text("Payment Verified: " + data + "BTC").fadeIn(100).removeClass('offscreenbottom');
						clearTimeout(timeoutId);
						jQuery('.preloader').fadeOut(100);
					} else if (data < btc && data > 0){
						more = btc - data;
						jQuery ('.verified').text("Insufficient Payment: " + data + "BTC (need " + more + " more)").fadeIn(100).removeClass('offscreenbottom').addClass("insufficient");
						clearTimeout(timeoutId);
						jQuery('.preloader').fadeOut(100);
					}
				});
			    var timeoutId = setTimeout(autoUpdate, 5000);
}

			  	
        });
    });

</script>
