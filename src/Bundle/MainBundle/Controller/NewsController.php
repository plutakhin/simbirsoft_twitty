<?php

namespace Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Bundle\MainBundle\Entity\News;
use Bundle\MainBundle\Form\NewsType;
use Bundle\MainBundle\Controller\BaseController;

/**
 * @TODO Реализовать работу с новостями
 * @Route("/news")
 */
class NewsController extends BaseController
{
    /**
     * @Route("/", name="news_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $tag = $request->get('tag');
        $news = $this->getRepository('News')->findFor($this->getUser(), $tag);

        return array(
            'news' => $news,
        );
    }

    /**
     * @Route("/create", name="news_create")
     * @Method("GET|POST")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $form = $this->createNewsForm($news);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->getRepository('News')->save($news);

                return $this->redirect($this->generateUrl('news_list'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }


    /**
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewsForm(News $news)
    {
        $form = $this->createForm(new NewsType($this->getUser()), $news, array(
            'action' => $this->generateUrl('news_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array(
            'class' => 'btn btn-primary btn-sm'
        )));

        return $form;
    }
}
