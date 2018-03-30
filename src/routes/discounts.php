<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Discounts\DiscountCalculator;

/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 22:15
 */

$app = new \Slim\App;

$app->post('/api/discounts', function (Request $request, Response $response) {

    try {
        $cType = $request->getHeader('Content-Type');
        if (strcmp($cType[0], 'application/json') !== false) {
            $order = json_decode($request->getBody());
            $discountCalculator = new DiscountCalculator();
            $order = $discountCalculator->calcDiscounts($order);
            return $response->withJSON($order);
        }
    } catch (Exception $e) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }

});