<?php

namespace AppBundle\Security;

use AppBundle\Controller\FacebookHelper;
use AppBundle\Entity\FacebookUser;
use AppBundle\Entity\User;
use Facebook\Facebook;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FacebookAdminProvider implements UserProviderInterface
{
    private $facebookSdk;

    private $helper;

    public function __construct(Facebook $sdk, FacebookHelper $helper)
    {
        $this->facebookSdk = $sdk;
        $this->helper = $helper;
    }

    public function loadUserByUsername($accessToken)
    {
        $response = $this->facebookSdk->get('/me?fields=id,name,email', $accessToken);
        $fbuser = $response->getGraphUser();

        $user = (new FacebookUser($fbuser))->addRole('ROLE_ADMIN')->setAccessToken($accessToken);
        $this->helper->saveUser($user);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // Note that if I don't see any reason to refresh the user atm, it may have to be done one day.
        return $user;
    }

    public function supportsClass($class)
    {
        return FacebookUser::class === $class;
    }
}
