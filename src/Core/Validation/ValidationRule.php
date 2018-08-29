<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 29.
 * Time: 8:37
 */

namespace MedevSlim\Core\Validation;


use Slim\Http\Request;
use Slim\Http\Response;

abstract class ValidationRule
{
    protected $validationParameters;


    public function __construct($validationParameters)
    {
        $this->validationParameters = $validationParameters;
    }


    abstract function validate(Request $request, Response $response, $args);
}