<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Bundle\MainBundle\Entity\News;
use Bundle\MainBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    private $news = array(
        'Это первое демо сообщение' => array('демо', 'сообщение'),
        'Стартует набор в школу программистов на PHP' => array('школа', 'программирование', 'php'),
        'Новый курс PHP открыт' => array('php'),
        'Выбираем решение для персонального файлохранилища' => array('файлохранилище'),
        'Оптимизация бизнес-процессов при помощи кривых выживаемости' => array('бизнес-процесс'),
        'Распознавание русской речи для колл-центров' => array('распознавание'),
        'Мощный домашний маршрутизатор своими руками' => array('маршрутизатор'),
        'Алгоритмы сжатия данных без потерь' => array('алгоритмы', 'сжатие данных'),
    );


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('demo_user')
            ->setEmail('email@example.com')
            ->setPassword('4ylaKxhwFK0PxCmm1C6tIzdlM5jwFYYQFM6Z/7+2I54E/cP7Ht5AfQ==');

        $manager->persist($user);
        $manager->flush();

        foreach ($this->news as $key => $value) {
            $news = new News();
            $news->setText($key);
            $news->setAuthor($user);
            foreach ($value as $tag) {
                $news->addPlainTags($tag);
            }
            $manager->persist($news);
            $manager->flush();
        }

    }
}