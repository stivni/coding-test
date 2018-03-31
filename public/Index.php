<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

// Discount Routers
require "../src/routes/routeDiscounts.php";

$app->run();
