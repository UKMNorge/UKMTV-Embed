<?php

use UKMNorge\Filmer\UKMTV\Filmer;
use UKMNorge\Filmer\UKMTV\Server\Server;

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

$film = Filmer::getById($_GET['id']);
$film->play();

// DET ER EN MP4-FIL (standard)
if ($film->harSmil() && $film->getExtension() == '.mp4') {
    // DET FINNES EN SMIL-FIL (BÅNDBREDDEVALG)
    // Fordi cachene kun er wowza-apps, og ikke tilgjengeliggjør
    // filmer via vanlig https:80, er siste utvei direkteadressering til storageserver
    $sources = 'sources: [{
        file: "' . Server::getWowzaUrl() . 'smil:' . $film->getSmilFile() . '/jwplayer.smil"
        },{
        file: "' . Server::getWowzaUrl() . 'smil:' . $film->getSmilFile() . '/playlist.m3u8"
        },{
        file: "' . Server::getStorageUrl() . '/' . $film->getFile() . '" 
        }]';
    // DET FINNES IKKE SMIL-FIL
} elseif ($film->getExtension() == '.mp4') {
    $sources = 'sources: [{
        file: "' . Server::getWowzaUrl() . $film->getFile() . '/playlist.m3u8"
        },{
        file: "' . Server::getStorageUrl() . $film->getFile() . '"
        }]';
}
// DET ER IKKE EN MP4-FIL (wow, gammelt)
else {
    $sources = 'file: "' . Server::getWowzaUrl() . $film->getFile() . '/playlist.m3u8"';
}
?>
var jwp_height = 562;
jQuery(document).ready(function(){
jQuery('#my-video, #my-video_wrapper').bind('resize', function(){
jwplayer('my-video').resize('100%', jwp_calc_height());
});
jwplayer('my-video').setup({
<?= $sources ?>,
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