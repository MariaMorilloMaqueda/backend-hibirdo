<?php
error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__.'/vendor/autoload.php';

define('BASE_URL','http://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['PHP_SELF']),'/',explode('?',$_SERVER['REQUEST_URI'])[0]).'/');
