<?php
session_start();

use Dotenv\Dotenv;
use Fiado\Core\Core;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

$core = new Core;

$core->run();