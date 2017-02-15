<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FacebookUser;
use AppBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Facebook\GraphNodes\GraphEdge;
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

    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct(
        FacebookRedirectLoginHelper $loginHelper,
        Router $router,
        Registry $doctrine
    ) {
        $this->loginHelper = $loginHelper;
        $this->router = $router;
        $this->doctrine = $doctrine;
    }

    public function loginPage($redirectUrl)
    {
        $redirectUrl = rtrim($redirectUrl, '/)');
        $permissions = ['email', 'user_photos'];

        return $this->loginHelper->getLoginUrl($redirectUrl, $permissions);
    }

    public function saveUser(FacebookUser $facebookUser)
    {
        $user = $this->doctrine->getRepository('AppBundle:User')->getByFacebookUser($facebookUser);
        if (empty($user)) {
            $em = $this->doctrine->getManager();
            $em->persist(User::createFromFacebookObject($facebookUser));
            $em->flush();
        }
    }
}
