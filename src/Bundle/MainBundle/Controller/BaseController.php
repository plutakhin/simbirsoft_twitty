<?php

namespace Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BaseController extends Controller
{
    /**
     * @param $entityName
     * @return EntityRepository
     */
    protected function getRepository($entityName)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = sprintf('MainBundle:%s', $entityName);

        return $em->getRepository($repository);
    }

    /**
     * Перевод сообщения
     * @param string $message
     * @param string $domain
     * @param array $params
     * @return string
     */
    protected function getTranslate($message, $domain = null, $params = array())
    {
        return $this->get('translator')->trans($message, $params, $domain);
    }
}
