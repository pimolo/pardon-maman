<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Contest;

/**
 * ContestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContestRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return Contest|null
     */
    public function getCurrentContest()
    {
        return $this->find(4);
    }
}
