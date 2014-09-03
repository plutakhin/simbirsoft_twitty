<?php

namespace Bundle\MainBundle\Repository;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Monolog\Logger;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\DBAL\LockMode;

use Bundle\MainBundle\Entity\User;
use Bundle\MainBundle\Entity\Core\BaseEntity;
use Bundle\MainBundle\Service\ImageProvider;
use Bundle\MainBundle\Entity\Core\BasePage;
use Bundle\MainBundle\Entity\Behavior\SoftDeletable\SoftDeletableInterface;
use Bundle\MainBundle\Constant\CacheConst;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;

/**
 * BaseRepository
 */
class BaseRepository extends EntityRepository
{
    /**
     * Сохранение сущности
     * @param $entity
     * @throws \Doctrine\ORM\ORMException
     */
    public function save($entity)
    {
        try {
            $em = $this->getEntityManager();
            if (is_null($entity->getId())) {
                $em->persist($entity);
            }
            $em->flush();
            
        } catch (\Exception $e) {
            throw new ORMException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Удаление сущности
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove($entity)
    {
        try {
            $em = $this->getEntityManager();
            $em->remove($entity);
            $em->flush();

        } catch (\Exception $e) {
            throw new ORMException('Не удается удалить объект ' . get_class($entity), 0, $e);
        }
    }

}