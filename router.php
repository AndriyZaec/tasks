<?php
/**
 * Created by PhpStorm.
 * User: andrij
 * Date: 10.07.15
 * Time: 9:35
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('env.class.php');

$env = new Env();

define("ENCRYPTION_KEY", "!@#$%^&*");

$selectQuery=$env->decrypt($_POST['data'],ENCRYPTION_KEY);
$result=$env->selectQuery($selectQuery);
foreach ($result as $resultEl) {
    echo $resultEl=$env->encrypt($resultEl,ENCRYPTION_KEY);
    echo $env->encrypt('<br>',ENCRYPTION_KEY);
}



