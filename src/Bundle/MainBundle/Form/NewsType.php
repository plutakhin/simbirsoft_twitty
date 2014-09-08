<?php

namespace Bundle\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

use Bundle\MainBundle\Entity\User;

class NewsType extends AbstractType
{
    /** @var \Bundle\MainBundle\Entity\User */
    private $author;

    /**
     * @param \Bundle\MainBundle\Entity\User $author
     */
    function __construct(User $author)
    {
        $this->author = $author;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'textarea', array(
                'label' => 'news.text',
            ))
            ->add('plainTags', null, array(
                'label' => 'news.plainTags',
                'attr' => array(
                    'class' => 'select2'
                )
            ))
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
            $form = $event->getForm();
            $entity = $event->getData();

            if ($entity instanceof \Bundle\MainBundle\Entity\News) {
                $entity->setAuthor($this->author);
                $entity->setPlainTags(explode('|', $entity->getPlainTags()));
            }
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'form',
            'data_class' => 'Bundle\MainBundle\Entity\News',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_mainbundle_news';
    }
}
