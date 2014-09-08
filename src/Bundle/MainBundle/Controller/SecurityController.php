<?php

namespace Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Bundle\MainBundle\Controller\BaseController;
use Bundle\MainBundle\Entity\User;
use Bundle\MainBundle\Form\SignupType;

/**
 * @TODO Реализовать систему регистрации, авторизации, логина
 */
class SecurityController extends BaseController
{

    /**
     * @Route("/login", name="login")
     * @Method("GET")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        }
        elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return array(
            'last_username' => $lastUsername,
            'error' => $error,
        );
    }

    /**
     * @Route("/signup", name="signup")
     * @Method("GET|POST")
     * @Template()
     */
    public function signupAction(Request $request)
    {
        $user = new User();
        $form = $this->createSignupForm($user);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), null);
                $user->setPassword($password);
                $this->getRepository('User')->save($user);

                return $this->redirect($this->generateUrl('login'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
    * @return \Symfony\Component\Form\Form The form
    */
    private function createSignupForm(User $user)
    {
        $form = $this->createForm(new SignupType(), $user, array(
            'action' => $this->generateUrl('signup'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'submit', 'attr' => array(
            'class' => 'btn btn-primary btn-sm'
        )));

        return $form;
    }
}
