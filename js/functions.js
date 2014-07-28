//process doge / btc

function keypadEntry(current, keypressed){
	amount = parseFloat(current);
	add = parseFloat(keypressed);
	
	if (keypressed != '00'){
		amount = (amount*10)+(add/100);
	} else {
		amount = amount * 100;
	}
	
	return amount.toFixed(2);
}