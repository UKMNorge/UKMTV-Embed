<?php
require_once('UKM/tv.class.php');
$TV = new tv($_GET['f']);
$TV->play();
$TV->size();
$TV->videofile();

if($TV->ext == '.mp4') {
	$sources = 'sources: [{
				    file: "rtmp://212.125.231.33/ukmtv/_definst_/mp4:'.$TV->file.'"
				},{
				    file: "http://212.125.231.33/ukmtv/_definst_/'.$TV->file.'/playlist.m3u8"
				},{
				    file: "http://video.ukm.no/'.$TV->file.'"
				}]';
} else {
	$sources = 'file: "http://212.125.231.33/'.$TV->file.'"';
}
?>
var jwp_height = 562;
jQuery(document).ready(function(){
	jQuery('#my-video, #my-video_wrapper').bind('resize', function(){
		jwplayer('my-video').resize('100%', jwp_calc_height());
	});
	jwplayer('my-video').setup({
	    <?= $sources ?>,
		primary: 'flash',
		<?= isset($_GET['autoplay']) || isset($_GET['autostart']) ? 'autostart: true,' : '' ?>
		title: 'Spill av',
	    image: '<?= $TV->image_url ?>',
	    width: '100%',
	    height: jwp_calc_height(),
	    startparam: "starttime",
	    logo: {
	        file: 'http://embed.ukm.no/logo/UKMtv_hvit_'+jwp_calc_logo()+'.png',
	        link: 'http://tv.ukm.no/',
	        linktarget: '_blank'
        }
	});
});
function jwp_calc_height() {
return Math.floor( ( parseInt(jQuery('#my-video').css('width')) / 16 ) * 9);
}
function jwp_calc_logo() {
width = parseInt(jQuery('#my-video').css('width'));
if(width > 600) {
	return '150';
}
if(width > 250) {
	return '100';
}
return '50';
}