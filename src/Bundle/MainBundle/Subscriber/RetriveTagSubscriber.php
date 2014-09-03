<?php

namespace Bundle\MainBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Bundle\MainBundle\Entity\News;

/**
 * RetriveTagSubscriber
 */
class RetriveTagSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->retrive($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->retrive($args);
    }

    private function retrive(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof News) {
            /**
             * @TODO Реализовать преобразование массива строковых Тегов из Новости в обьекты сущности Tag и привязать
             */
        }
    }
}
