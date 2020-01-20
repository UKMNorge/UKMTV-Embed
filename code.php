<?php

use UKMNorge\Filmer\UKMTV\Filmer;

header('Access-Control-Allow-Headers: true');
header('Access-Control-Allow-Origin: ukm.no');
header('Access-Control-Request-Method: OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');

require_once('UKMconfig.inc.php');
require_once('UKM/Autoloader.php');

$film = Filmer::getById( intval( $_GET['id'] ));
echo $film->getEmbedHtml();