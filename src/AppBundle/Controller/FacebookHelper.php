<?php

namespace AppBundle\Controller;

use Facebook\Facebook;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

    public function __construct(FacebookRedirectLoginHelper $loginHelper, Router $router)
    {
        $this->loginHelper = $loginHelper;
        $this->router = $router;
    }

    public function loginPage()
    {
        $redirectUrl = rtrim($this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL), '/)');
        $permissions = ['email'];

        return $this->loginHelper->getLoginUrl($redirectUrl, $permissions);
    }
}
