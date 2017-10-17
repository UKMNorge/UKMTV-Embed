<?php

#require_once('server_upgrade.php');

require_once('UKM/innslag.class.php');
require_once('UKM/monstring.class.php');

require_once('UKM/tv.class.php');
if(isset($_GET['searchfile']))
	$TV = new tv($_GET['searchfile']);
else
	$TV = new tv($_GET['f']);
?>
<!DOCTYPE html>
<html>
<head>
<title>embed.UKM.no</title>
<style>
body,
html {
	background: #000;
	overflow: hidden;
	padding: 0;
	margin: 0;
	width: 100%;
	height: 100%;
}
</style>
<?php
if($TV->id) { ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        	<script src="//embed.ukm.no/jwplayer-7.9.3/jwplayer.js"></script>
		<script>jwplayer.key="O8fn25zm2lKsP+6rv/8DC//tszaOMt9kNWEFwA==";</script>
	<script language="javascript" src="//embed.<?php echo UKM_HOSTNAME; ?>/info/<?= $_GET['f'] ?><?= isset($_GET['autoplay']) || isset($_GET['autostart']) ? '?autoplay=true': ''?>"></script>
<?php } ?>
<script type="text/javascript">
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-46216680-7']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
</script>
</head>
<body>
	<?php if(!$TV->id) { ?>
		<div align="center">
			<img src="logo/UKMtv_hvit_300.png" alt="UKMtv_hvit_300" width="" height="" />
			<h3 style="color: #fff;">Ingen video valgt!</h3>
		</div>
	<?php } else { ?>
		<div id="my-video" width="100%"></div>
	<?php } ?>
</body>
</html>
