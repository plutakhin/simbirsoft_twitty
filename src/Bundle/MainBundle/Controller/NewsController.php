<?php

namespace Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
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
}
