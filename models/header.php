<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
require_once("models/cryptofunctions.php");
require_once("db-settings.php");
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="apple-mobile-web-app-capable" content="yes" />  
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link rel="apple-touch-startup-image" href="images/splash.png" />
<link rel="apple-touch-icon-precomposed" href="images/dogepos-icon.png"/> 
<title><?php echo $websiteName; ?></title>
<link href='<?php echo $template; ?>' rel='stylesheet' type='text/css' />
<link href='960.css' rel='stylesheet' type='text/css' />
<link href='style.css' rel='stylesheet' type='text/css' />
<script src='models/funcs.js' type='text/javascript'></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='text/javascript' src='jquery-qrcode-master/jquery.qrcode.min.js'></script>
<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33982592-4', 'dogepos.com');
  ga('send', 'pageview');

</script>

<script type='application/javascript' src='/fastclick/lib/fastclick.js'></script>

<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript">(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>

</script>
</head>

<script type="text/javascript">
jQuery(document).ready(function(){

	window.addEventListener('load', function() {
	    new FastClick(document.body);
	}, false);

	var a=document.getElementsByTagName("a");
	for(var i=0;i<a.length;i++)
	{
	    a[i].onclick=function()
	    {
	        window.location=this.getAttribute("href");
	        return false
	    }
	}

	function slidenav(dowhat) {
		if (dowhat == close){
		jQuery('.slidenav').removeClass('slid');
		jQuery('.mainwrap').removeClass('slid');
		} else {
		jQuery('.slidenav').toggleClass('slid');
		jQuery('.mainwrap').toggleClass('slid');
		}
	}
	
	jQuery('.mainwrap').click(function(){
		slidenav(close);
	});
	jQuery('#slideoutnav').click(function(e){
		e.stopPropagation();
		slidenav();
	});
	
	
});
</script>



<body>
<div class="mainwrap">
<header>
	<div class="header_container container_12">
		<h1 class="logo">
		<?php if(isUserLoggedIn()) { 
					echo '<a href="/account.php">DogePos</a></h1>';
			  } else { 
					echo '<a href="/">DogePos</a></h1>';
			  }?>
		<div class="topnav">
			<?php if(isUserLoggedIn()) { 
					echo '<a href="#" id="slideoutnav"><i class="fa fa-bars"></i></a>';
			  } else { 
				  	include("top-nav.php");
				  	echo '<a href="#" id="slideoutnav" class="mobile"><i class="fa fa-bars"></i></a>';
			  }?>
			
		</div>
	</div>
</header>

<?php if(isUserLoggedIn()) { 
			global_message();
			//echo "<div class='warning'>WARNING DOGEPOS USERS: There is a fork in the blockchain. Please halt transactions until resolved</div>";
	  } else { 	  }?>

