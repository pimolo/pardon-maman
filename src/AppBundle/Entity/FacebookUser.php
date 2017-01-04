<?php

namespace AppBundle\Entity;

use Facebook\GraphNodes\GraphUser;
use Symfony\Component\Security\Core\User\UserInterface;

class FacebookUser implements UserInterface
{
    /**
     * @var GraphUser
     */
    private $graphUser;

    /**
     * @param GraphUser $fbuser
     */
    public function __construct(GraphUser $fbuser)
    {
        $this->graphUser = $fbuser;
    }

    /**
     * @return GraphUser
     */
    public function getGraphUser()
    {
        return $this->graphUser;
    }

    /**
     * @param GraphUser $graphUser
     */
    public function setGraphUser($graphUser)
    {
        $this->graphUser = $graphUser;
    }


    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
        // TODO: Implement getRoles() method.
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return null;
        // TODO: Implement getPassword() method.
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getGraphUser()->getEmail();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        return null;
        // TODO: Implement eraseCredentials() method.
    }
}
