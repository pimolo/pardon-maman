<?php

namespace AppBundle\Security;

use AppBundle\Entity\FacebookUser;
use AppBundle\Entity\User;
use Facebook\Facebook;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FacebookUserProvider implements UserProviderInterface
{
    private $facebookSdk;

    public function __construct(Facebook $sdk)
    {
        $this->facebookSdk = $sdk;
    }

    public function loadUserByUsername($accessToken)
    {
        $response = $this->facebookSdk->get('/me?fields=id,name,email', $accessToken);

        $fbuser = $response->getGraphUser();

        /*
         * TODO: implement that
        return (new User)
            ->setFirstname($fbuser->getFirstName())
            ->setLastname($fbuser->getLastName())
            ->setEmail($fbuser->getEmail())
            ->setAge($fbuser->getBirthday())
            ->setLocation($fbuser->getHometown())
            ->setUsername($fbuser->getEmail())
        ;
        */
        return (new FacebookUser($fbuser));
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
