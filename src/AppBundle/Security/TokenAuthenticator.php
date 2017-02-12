<?php

namespace AppBundle\Security;

use Facebook\Helpers\FacebookRedirectLoginHelper;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
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

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $currentUrl = $this->router->generate($request->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL);
        $login = $this->router->generate('login', ['redirect' => $currentUrl], UrlGeneratorInterface::ABSOLUTE_URL);

        return new RedirectResponse($login);
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $this->loginHelper->getAccessToken()) {
            return null;
        }

        return ['token' => $token];
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];

        return $userProvider->loadUserByUsername($token);
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
        // TODO: Implement checkCredentials() method.
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
        return null;
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
