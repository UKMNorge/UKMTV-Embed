<?php

use UKMNorge\Filmer\UKMTV\Filmer;
use UKMNorge\Filmer\UKMTV\Server\Server;

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

$film = Filmer::getById($_GET['id']);
$film->play();

?>
var jwp_height = 562;
jQuery(document).ready(function(){
jQuery('#my-video, #my-video_wrapper').bind('resize', function(){
jwplayer('my-video').resize('100%', jwp_calc_height());
});
jwplayer('my-video').setup({
file: '<?= Server::getWowzaUrl() . $film->getFile() . '/playlist.m3u8' ?>',
<?= isset($_GET['autoplay']) || isset($_GET['autostart']) ? 'autostart: true,' : '' ?>
title: 'Spill av',
image: '<?= $film->getBildeUrl() ?>',
width: '100%',
height: jwp_calc_height(),
startparam: "starttime",
logo: {
file: 'https://embed.<?= UKM_HOSTNAME ?>/logo/UKMtv_hvit_'+jwp_calc_logo()+'.png',
link: 'https://tv.<?= UKM_HOSTNAME ?>/',
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