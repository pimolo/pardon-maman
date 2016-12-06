<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contest
 *
 * @ORM\Table(name="contest")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContestRepository")
 */
class Contest
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled;

    /**
     * @var string
     *
     * @ORM\Column(name="prize", type="text")
     */
    private $prize;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="datetime")
     */
    private $dateUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;

    /**
     * @var Picture[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Picture", mappedBy="contests")
     */
    private $pictures;

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
     * Set title
     *
     * @param string $title
     *
     * @return Contest
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Contest
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return Contest
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Contest
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return Contest
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return bool
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set prize
     *
     * @param string $prize
     *
     * @return Contest
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }

    /**
     * Get prize
     *
     * @return string
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     *
     * @return Contest
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Contest
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param bool $deleted
     * @return Contest
     */
    public function setDeleted($deleted = true)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param Picture[]|ArrayCollection $pictures
     * @return Contest
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * @param Picture $picture
     * @return Contest
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures->add($picture);

        return $this;
    }

    /**
     * @param Picture $picture
     * @return Contest
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);

        return $this;
    }

    /**
     * @return Picture[]|ArrayCollection
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}
