<?php

namespace Milio\UserBundle\Controller;

use Milio\UserBundle\Form\Type\LoginUserFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

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
    ) {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }

    /**
     * @return Response
     */
    public function showAction()
    {
        $form = $this->formFactory->create(new LoginUserFormType());

        return $this->templating->renderResponse('MilioUserBundle:Login:login.html.twig', ['form' => $form->createView()]);
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
