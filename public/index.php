<?php

use Application\Kernel;
use Symfony\Component\HttpFoundation\Request;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$kernel = new Kernel();

$request = Request::createFromGlobals();
$response = $kernel->handle($request)->send();

