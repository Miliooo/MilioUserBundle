<?php

namespace Milio\UserBundle\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class LoginUserController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class LoginUserController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface      $templating
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EngineInterface $templating
    )
    {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();


        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);


        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => null,
        );


        return $this->templating->renderResponse('MilioUserBundle:Login:login.html.twig', array('data' => $data));
    }

    /**
     * @throws \RuntimeException
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @throws \RuntimeException
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
