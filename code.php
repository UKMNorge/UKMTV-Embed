<?php
header('Access-Control-Allow-Headers: true');
header('Access-Control-Allow-Origin: ukm.no');
header('Access-Control-Request-Method: OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');

require_once('UKM/tv.class.php');
$TV = new tv($_GET['id']);
$TV->size();
?>
<iframe src="<?= $TV->embed_url ?>" width="<?= $TV->width ?>" height="<?= $TV->height ?>" class="ukmtv" border="0" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true" allowfullscreen="true"></iframe>
<?php
/*

require_once('../tv/inc/config.inc.php');
$video = videoInfo( $_GET['id'] );

list($width, $height) = getimagesize(STORAGE.$video['tv_img']);
$ratio = $width / $height;

if($width > 930) {
	$width = 930;
	$height = $width / $ratio;
}
$width = round($width);
$height = round($height);
?>
<iframe src="<?= str_replace('tv.ukm','embed.ukm',$video['full_url'])?>" width="<?= $width ?>" height="<?= $height ?>" class="ukmtv" border="0" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true" allowfullscreen="true"></iframe>
*/