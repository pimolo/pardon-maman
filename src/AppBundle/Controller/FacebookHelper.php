<?php

namespace AppBundle\Controller;

use Facebook\Helpers\FacebookRedirectLoginHelper;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class FacebookHelper
{
    /**
     * @var FacebookRedirectLoginHelper
     */
    private $loginHelper;

    /**
     * @var Router
     */
    private $router;

    public function __construct(
        FacebookRedirectLoginHelper $loginHelper,
        Router $router
    ) {
        $this->loginHelper = $loginHelper;
        $this->router = $router;
    }

    public function loginPage($redirectUrl)
    {
        $redirectUrl = rtrim($redirectUrl, '/)');
        $permissions = ['email'];

        return $this->loginHelper->getLoginUrl($redirectUrl, $permissions);
    }
}
