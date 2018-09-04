<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:57
 */

namespace MedevSlim\Core\Services\Auth\OAuth\GrantType;


use MedevSlim\Core\APIAction\APIAction;
use MedevSlim\Core\Services\Auth\OAuth\OAuthService;
use MedevSuite\Application\Auth\OAuth\Token\TokenProvider;
use Psr\Container\ContainerInterface;

abstract class GrantType extends APIAction
{
    /**
     * @var TokenProvider
     */
    protected $tokenProvider;
    protected $authService;

    public function __construct(ContainerInterface $container)
    {

        parent::__construct($container, []);
    }


    public abstract function getName();

    public function setAuthService(OAuthService $authService){
        $this->authService = $authService;
    }
}