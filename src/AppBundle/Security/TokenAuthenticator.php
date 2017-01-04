<?php

namespace AppBundle\Security;

use Facebook\Helpers\FacebookRedirectLoginHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $loginHelper;

    public function __construct(FacebookRedirectLoginHelper $loginHelper)
    {
        $this->loginHelper = $loginHelper;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response('auth required', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $this->loginHelper->getAccessToken()) {
            return null;
        }

        return ['token' => $token->getValue()];
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
