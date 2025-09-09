<?php
require_once __DIR__.'/setup.php';

session_start();

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}
