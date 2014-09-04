<?php

namespace Bundle\MainBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Bundle\MainBundle\Entity\News;
use Bundle\MainBundle\Entity\Tag;

/**
 * RetriveTagSubscriber
 */
class RetriveTagSubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->retrive($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->retrive($args);
    }

    /**
     * Пребразование строковых тегов в объекты Tag
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    private function retrive(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $tagRep = $em->getRepository('MainBundle:Tag');

        if ($entity instanceof News) {
            $plainTags = $entity->getPlainTags();

            if (is_array($plainTags)) {
                foreach ($plainTags as $plainTag) {
                    if (! $tag = $tagRep->findOneByName($plainTag)) {
                        $tag = new Tag();
                        $tag->setName($plainTag);
                        $em->persist($tag);
                    }

                    $entity->addTag($tag);
                }
            }
        }
    }
}
