<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255)
     */
    private $facebookId;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;

    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

    /**
     * @var Picture[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Contest", inversedBy="pictures")
     */
    private $contests;

    /**
     * @var string
     *
     * @ORM\Column(name="representation", type="string", length=255)
     */
    private $representation;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="photos")
     */
    private $user;

    public function __construct()
    {
        $this->contests = new ArrayCollection();
        $this->deleted = false;
        $this->likes = 0;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return Picture
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Picture
     */
    public function setDeleted($deleted = true)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Picture
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param Picture[]|ArrayCollection $contests
     * @return Picture
     */
    public function setContests($contests)
    {
        $this->contests = $contests;

        return $this;
    }
    /**
     * @param Contest $contest
     * @return Picture
     */
    public function addContest(Contest $contest)
    {
        $this->contests->add($contest);

        return $this;
    }

    /**
     * @param Contest $contest
     * @return Picture
     */
    public function removeContest(Contest $contest)
    {
        $this->contests->removeElement($contest);

        return $this;
    }

    /**
     * @return Picture[]|ArrayCollection
     */
    public function getContests()
    {
        return $this->contests;
    }

    /**
     * @return string
     */
    public function getRepresentation()
    {
        return $this->representation;
    }

    /**
     * @param string $representation
     * @return Picture
     */
    public function setRepresentation($representation)
    {
        $this->representation = $representation;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Picture
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}

