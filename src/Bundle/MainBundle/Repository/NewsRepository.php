<?php

namespace Bundle\MainBundle\Repository;

use Bundle\MainBundle\Constant\NewsConst;
use Bundle\MainBundle\Entity\News;
use Bundle\MainBundle\Repository\BaseRepository;
use Doctrine\ORM\Query;

use Bundle\MainBundle\Entity\User;

/**
 * NewsRepository
 */
class NewsRepository extends BaseRepository
{
    public function findFor(User $user, $tag = null)
    {
        $query = $this->createQueryBuilder('n');
        $query
            ->where('n.author in (:subs)')
            ->setParameter('subs', $user->getSubscriptions()->toArray())
            ->setMaxResults(100)
            ->orderBy('n.id', 'DESC')
            ;

        if ($tag) {
            $query
                ->innerJoin('n.tags', 't')
                ->andWhere('t.name = :name')
                ->setParameter('name', $tag)
                ;
        }

        return $query->getQuery()->getResult();
    }
}