<?php

namespace Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Bundle\MainBundle\Controller\BaseController;

/**
 * @Route("/api")
 */
class APIController extends BaseController
{
    /**
     * @Route("/subscribe/{id}", name="api_subscribe")
     * @Method("POST")
     */
    public function subscribeAction($id, Request $request)
    {
        if (!$user = $this->getRepository('User')->find($id)) {
            return $this->generateError('user.notFound');
        }
        if ($user == $this->getUser()) {
            return $this->generateError('user.notAvailable');
        }
        if ($this->getUser()->getSubscriptions()->contains($user)) {
            return $this->generateError('user.alreadySubscribed');
        }

        $this->getUser()->addSubscription($user);
        $this->getRepository('User')->save($this->getUser());

        $response = new JsonResponse(array('action' => 'toggleClass'));
        
        return $response;
    }
    /**
     * @Route("/unsubscribe/{id}", name="api_unsubscribe")
     * @Method("POST")
     */
    public function unsubscribeAction($id, Request $request)
    {
        if (!$user = $this->getRepository('User')->find($id)) {
            return $this->generateError('user.notFound');
        }
        if ($user == $this->getUser()) {
            return $this->generateError('user.notAvailable');
        }
        if (!$this->getUser()->getSubscriptions()->contains($user)) {
            return $this->generateError('user.notSubscribed');
        }

        $this->getUser()->removeSubscription($user);
        $this->getRepository('User')->save($this->getUser());

        $response = new JsonResponse(array('action' => 'toggleClass'));

        return $response;
    }

    /**
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function generateError($message)
    {
        $response = new JsonResponse();
        $response->setData(array(
            'error' => $this->getTranslate($message, 'error')
        ));

        return $response;
    }
}
