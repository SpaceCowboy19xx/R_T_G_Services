<?php

use denbora\R_T_G_Services\casino\Casino;
use denbora\R_T_G_Services\casino\CasinoRest;
use denbora\R_T_G_Services\examples\Create;
use denbora\R_T_G_Services\examples\Loader;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../experiments/config.php';

$casino = new Casino($base_url, $certificate, $rtgPassword);
$casinoRest = new CasinoRest($restBaseUrl, $crt, $key, $rtgPassword);

$method = 'createPlayer';
$service = 'Player';

try {
    //Loader::call($service, $method, $casino);
    Loader::call($service, $method, $casino);
    /*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Create::savePlayer($_POST, $casino);
    } else {
        Create::printForm();
    }*/
} catch (\Exception $e) {
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
}
