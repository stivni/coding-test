<?php
/**
 * Created by PhpStorm.
 * User: bertverstraete
 * Date: 30/03/18
 * Time: 23:05
 */

namespace App\Helpers;

use JsonSchema\Validator;

class jsonHelper
{

    static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    static function jsonSchemaChecker($data)
    {
        $data = json_decode($data);

        $validator = new Validator();
        $validator->validate($data, (object)['$ref' => 'file://' . realpath(__dir__ . '/discountJSONSchema.json')]);


        if ($validator->isValid()) {
            return true;
        } else {
            return false;
        }
    }

}