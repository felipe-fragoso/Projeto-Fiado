<?php
session_start();

use Dotenv\Dotenv;
use Fiado\Core\Auth;
use Fiado\Core\Core;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

date_default_timezone_set($_SERVER["TIMEZONE"]);

$core = new Core(Auth::getSystem());

$core->run();