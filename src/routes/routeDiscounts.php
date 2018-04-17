<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Discounts\DiscountCalculator;
use App\Helpers\jsonHelper;

/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 22:15
 */

// TODO IMPLEMENT PARTIAL DISCOUNT

$app = new \Slim\App;

$app->post('/api/discounts', function (Request $request, Response $response) {


    $cType = $request->getHeader('Content-Type');

    if (strcmp($cType[0], 'application/json') !== false &&
        jsonHelper::isJson($request->getBody()) &&
        jsonHelper::jsonSchemaChecker($request->getBody())) {

        $order = json_decode($request->getBody());
        $discountCalculator = new DiscountCalculator();
        $discountCalculator->calcDiscounts($order);
        return $response->withJSON($order)->withStatus(200);
    } else {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }



});



