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


<script type="text/javascript" src="/js/functions.js"></script>

<div class='container container_12'>
	<div class="currency">
		<img src="images/dogecoin.png">
		<p class="supplemental">Converted Amount</p>
		<p class="converted">&#393; <span class="doge"></span></p>
	</div>
	<div class="amount">
		<form method="post">
			<label for="dollars" class="symbol"><?php echo $loggedInUser->currencySymbol();?></label>
			<input type="number" name="dollars" id="dollars" class="dollars" value="0.00">
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
				<div class="btnkey">clr</div>
				<div class="key">0</div>
				<div class="key">00</div>
			</div>
			<input type="submit" id="submit" >
		</form>
	</div>
	<div class="transaction_container grid_10 push_1">
		<div class="instructions">Please send <span class="green"><span class="conversion"></span> DOGE</span> to the address below:</div>
		<div class="box">
			<div class="textaddress"></div><br>
			<div class="addressqr"></div>
		</div>
		<div class="preloader"><img src="images/ajax-loader.gif"></div>
		<div class="verified offscreenbottom"></div>
		<a href="/account.php" class="new"><i class="fa fa-plus-circle"></i></a>
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
		var getaddress = $.ajax( '/models/get_address.php' + '?user=' + <?php echo $loggedInUser->user_id; ?> + '&type=doge' );
			  getaddress.done(function(data) {
			  	address = getAddress2(data);
			  	//clear any stacked payments
			  	var clear = $.ajax( '/models/verify.php' + '?address=' + address + '&user=' + <?php echo $loggedInUser->user_id; ?> + '&fiatcurrency=<?php echo $loggedInUser->currency; ?>' );
			  	clear.done(function(data){
				  	//alert('/models/verify.php' + '?address=' + address + '&user=' + <?php echo $loggedInUser->user_id; ?>);
				});
		 });
		
	
		<?php if (isMobile()) {?>
		jQuery('#dollars').focus();
		<?php } ?>

	
		//number pad jquery stuff
		 $('.key').click(function(event){
        var numBox = jQuery('#dollars');
        
        numBox.val(keypadEntry(numBox.val(), this.innerHTML));
         
        jQuery('#dollars').trigger("keyup");
        event.stopPropagation();
    });


    
    
    $('.btnkey').click(function(event){
        if(this.innerHTML == 'clr'){
            var numBox = jQuery('#dollars');
            numBox.val('0.00');
            //trigger keyup to reprocess conversion
			jQuery('#dollars').trigger("keyup");
			event.stopPropagation();
        }
    });
		
		
		jQuery('#dollars').keyup(function(){
			amount = jQuery(this).val();
			var tempconversion = $.ajax( '/models/get_doge_conversion.php' + '?amount=' + amount + '&currency=<?php echo $loggedInUser->currency;?>')
				  .done(function(data) {
				  doge = getConversion2(data);
				  jQuery('.converted .doge').text(doge);
				  });
		});
		
		
			
		jQuery('#submit').click(function(event){ //fetch search results whenever a key is pressed
		   	  var amount;
		   	  
			  event.preventDefault();			
			  jQuery(".amount").addClass('offscreenright').fadeOut(600);
			  jQuery(".currency").addClass('offscreenleft').fadeOut(600);
			  jQuery("#dollars").blur();
			  amount = jQuery('#dollars').val();
			  
			  //fire first ajax call for conversion
              var conversion = $.ajax( '/models/get_doge_conversion.php' + '?amount=' + amount + '&currency=<?php echo $loggedInUser->currency;?>' )
				  .done(function(data) {
				  //when it returns done, process it...
				    doge = getConversion2(data);
				    	
					    jQuery('.transaction_container').fadeIn(500);
					    //and start checking...
					    autoUpdate();
				  })
				  .fail(function() {
				    alert( "error" );
				  })
				  
			  

			  
			  function autoUpdate(){
				//update every 5 seconds
			    var payment = $.ajax( '/models/verify.php' + '?address=' + address + '&user=' + <?php echo $loggedInUser->user_id; ?> + '&fiatcurrency=<?php echo $loggedInUser->currency; ?>' );
				payment.done(function(data){
					if (data >= doge){
						jQuery ('.verified').text("Payment Verified: " + data + "DOGE").fadeIn(100).removeClass('offscreenbottom');
						clearTimeout(timeoutId);
						jQuery('.preloader').fadeOut(100);
					} else if (data < doge && data > 0){
						more = doge - data;
						jQuery ('.verified').text("Insufficient Payment: " + data + "DOGE (need " + more + " more)").fadeIn(100).removeClass('offscreenbottom').addClass("insufficient");
						jQuery('.preloader').fadeOut(100);
						clearTimeout(timeoutId);
					}
				});
			    var timeoutId = setTimeout(autoUpdate, 5000);
}

			  	
        });
    });

</script>
