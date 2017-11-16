<?php
require_once('UKMconfig.inc.php');
require_once('UKM/tv.class.php');
$TV = new tv($_GET['f']);
$TV->play();
$TV->size();
$TV->videofile();

// Get the IP of a cache we can use to serve the files
$cacheIP = $TV->getCacheIP();
$appName = 'ukmtvhttp';

#if( $_SERVER['HTTP_CF_CONNECTING_IP'] == '81.0.146.162') {
#	$cacheIP = 'wowza.video.ukm.no';
#}

$ips_with_manual_cache = array('80.212.165.177','81.0.146.162', '195.204.59.62', '2001:4643:6d12:0:e2:56df:f787:7d3c');
if( false ) {# in_array( $_SERVER['HTTP_CF_CONNECTING_IP'], $ips_with_manual_cache) || in_array( $_SERVER['REMOTE_ADDR'], $ips_with_manual_cache) ) {
	echo "console.log('CURRENTLY IN DEBUG MODE FOR IP ". $_SERVER['HTTP_CF_CONNECTING_IP'] ."');";
	$cacheIP = '109.239.235.85';
}

if( empty( $cacheIP ) ) {
	require_once('UKM/mail.class.php');
	$mail = new UKMmail();
	$mail->to('support@ukm.no,marius@ukm.no,jardar@ukm.no')
		 ->subject('UKM-TV CACHE-ERROR')
		 ->message('Det er for øyeblikket ingen aktive cacher i UKM-TV, som betyr at UKM-TV er nede')
		 ->ok();
}

// DET ER EN MP4-FIL (standard)
if($TV->ext == '.mp4') {
	// DET FINNES EN SMIL-FIL (BÅNDBREDDEVALG)
	if( 'true' == $TV->file_exists_smil ) {
		$sources = 'sources: [{
			file: "http://'.$cacheIP.'/'.$appName.'/_definst_/smil:'.str_replace('_720p.mp4','.smil', $TV->file).'/jwplayer.smil"
			},{
			file: "http://'.$cacheIP.'/'.$appName.'/_definst_/smil:'.str_replace('_720p.mp4','.smil', $TV->file).'/playlist.m3u8"
			},{
			file: "https://videoserver.ukm.no/'.$appName.'/_definst_/smil:'.str_replace('_720p.mp4','.smil', $TV->file).'/manifest.mpd"
			},{
			file: "https://videoserver.ukm.no/'.$appName.'/_definst_/smil:'.str_replace('_720p.mp4','.smil', $TV->file).'/manifest.f4m"
			},{
			file: "'.$TV->storageurl.'/'.$TV->file.'"
			}]';
	}
	// DET FINNES IKKE SMIL-FIL
	else {
		$sources = 'sources: [{
				file: "rtmp://'.$cacheIP.'/'.$appName.'/_definst_/mp4:'.$TV->file.'"
				},{
				file: "http://'.$cacheIP.'/'.$appName.'/_definst_/'.$TV->file.'/playlist.m3u8"
				},{
				file: "'.$TV->storageurl.$TV->file.'"
				}]';
	}
}
// DET ER IKKE EN MP4-FIL (wow, gammelt)
else {
	$sources = 'file: "'.$TV->storageurl.$TV->file.'"';
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
	        file: 'https://embed.<?= UKM_HOSTNAME ?>/logo/UKMtv_hvit_'+jwp_calc_logo()+'.png',
	        link: 'http://tv.<?= UKM_HOSTNAME ?>/',
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
console.log('Playing from <?php echo $cacheIP; ?> (SMIL <?php echo $TV->file_exists_smil ?>) ');
