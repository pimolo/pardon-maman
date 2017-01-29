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
     * @var array
     */
    private $roles;

    /**
     * @param GraphUser $fbuser
     */
    public function __construct(GraphUser $fbuser)
    {
        $this->graphUser = $fbuser;
        $this->roles = ['ROLE_USER'];
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
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @param array $roles
     * @return FacebookUser
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles;
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
