<?php

namespace Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Bundle\MainBundle\Controller\BaseController;

/**
 * @TODO Реализовать Профиль пользователя, редактирование профиля, отображение стороннего профиля
 * @Route("/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", name="user_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $users = $this->getRepository('User')->findAll();

        return array(
            'users' => $users,
        );
    }
}
