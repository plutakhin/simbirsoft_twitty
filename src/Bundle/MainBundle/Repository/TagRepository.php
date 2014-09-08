<?php

namespace Bundle\MainBundle\Repository;

use Bundle\MainBundle\Constant\NewsConst;
use Bundle\MainBundle\Entity\News;
use Bundle\MainBundle\Repository\BaseRepository;
use Doctrine\ORM\Query;

/**
 * TagRepository
 */
class TagRepository extends BaseRepository
{
    public function search($term)
    {
        $query = $this->createQueryBuilder('t');
        $query
            ->select('t.name as id, t.name as text')
            ->where('t.name LIKE :term')
            ->setParameter('term', sprintf('%%%s%%', $term))
            ->setMaxResults(50)
            ->orderBy('t.name', 'ASC')
            ;

        return $query->getQuery()->getArrayResult();
    }
}