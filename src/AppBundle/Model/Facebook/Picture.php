<?php

namespace AppBundle\Model\Facebook;

use AppBundle\Entity\FacebookUser;
use AppBundle\Model\DTOInterface;

class Picture extends DTOInterface
{
    /**
     * @var int
     */
    public $facebookId;

    /**
     * @var FacebookUser
     */
    public $user;

    /**
     * @var string
     */
    public $photoLink;

}
