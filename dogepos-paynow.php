<?php 
require_once("models/config.php");
require_once("models/db-settings.php"); //Require DB connection
require_once("models/cryptofunctions.php");
require_once("models/header.php"); 
require_once("models/ajax_calls.php");



print_r($_POST);

echo "let's process payments!";
$amount = $_POST['amount'];
$user = $_POST['account'];
$user = substr($user, 2);
$user = $user - 100;
$fiatcurrency = $_POST['fiatcurrency'];

$amountcrypto = get_doge_conversion($amount, 'USD');
echo $amountcrypto;
echo "==".$user;?>

<div class='container container_12'>
	<div class="currency">
		<img src="images/dogecoin.png">
		<p class="supplemental">Converted Amount</p>
		<p class="converted">&#393; <span class="doge"></span></p>
	</div>
	<div class="amount">
		<form method="post" id="customer">
			<label for="first">First Name:
				<input type="text" name="first" id="first">
			</label><br>
			<label for="last">Last Name:
				<input type="text" name="last" id="last">
			</label><br>
			<label for="email">Email Address:
				<input type="email" name="email" id="email">
			</label><br>
			<label for="address">Shipping Address:
				<input type="text" name="address" id="address">
			</label><br>
			<label for="address2">Address Cont'd:
				<input type="text" name="address2" id="address2">
			</label><br>
			<label for="city">City:
				<input type="text" name="city" id="city">
			</label><br>
			<label for="state">State:
				<input type="text" name="state" id="state">
			</label><br>
			<label for="zip">Postal Code:
				<input type="text" name="zip" id="zip">
			</label><br>
						
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
		var getaddress = $.ajax( '/models/get_address.php' + '?user=' + <?php echo $user; ?> + '&type=doge' );
			  getaddress.done(function(data) {
			  	address = getAddress2(data);
			  	//clear any stacked payments
			  	var clear = $.ajax( '/models/verify.php' + '?address=' + address + '&user=' + <?php echo $user; ?> + '&fiatcurrency=<?php echo $fiatcurrency; ?>' );
			  	clear.done(function(data){
				  	//alert('/models/verify.php' + '?address=' + address + '&user=' + <?php echo $user; ?>);
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
			var tempconversion = $.ajax( '/models/get_doge_conversion.php' + '?amount=' + amount + '&currency=<?php echo $fiatcurrency;?>')
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
			  amount = 0 + <?php echo $amount;?>;
			  frm = $('#customer');
			  customerdata = JSON.stringify(frm.serializeArray());
			  alert(customerdata);

			  
			  //fire first ajax call for conversion
              var conversion = $.ajax( '/models/get_doge_conversion.php' + '?amount=' + amount + '&currency=<?php echo $fiatcurrency;?>' )
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
			    var payment = $.ajax( '/models/verify.php' + '?address=' + address + '&user=' + <?php echo $user; ?> + '&fiatcurrency=<?php echo $fiatcurrency; ?>' + '&getinsert=true&customer='+customerdata );
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


<?php include("footer.php");?>
