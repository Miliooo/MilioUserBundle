<?php

namespace Milio\UserBundle\Controller;

use Milio\User\Domain\ValueObjects\BasicUsername;
use Milio\User\Domain\ValueObjects\Password;
use Milio\User\Domain\Write\Command\RegisterUserCommand;
use Milio\UserBundle\Form\Type\RegisterUserFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Broadway\CommandHandling\CommandBusInterface;
use Broadway\CommandHandling\CommandHandlerInterface;
use Milio\User\Domain\ValueObjects\StringUserId;

/**
 * Class RegisterUserController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserController
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
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @var CommandHandlerInterface
     */
    private $commandHandler;

    /**
     * @param FormFactoryInterface    $formFactory
     * @param EngineInterface         $templating
     * @param CommandBusInterface     $commandBus
     * @param CommandHandlerInterface $commandHandler
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EngineInterface $templating,
        CommandBusInterface $commandBus,
        CommandHandlerInterface $commandHandler
    ) {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->commandBus = $commandBus;
        $this->commandHandler = $commandHandler;
    }

    /**
     * @return Response
     */
    public function showAction()
    {
        $form = $this->formFactory->create(new RegisterUserFormType());

        return $this->templating->renderResponse('MilioUserBundle:Registration:registration.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     */
    public function updateAction(Request $request)
    {
        $registerUserCommand = new RegisterUserCommand(
            new StringUserId('5'),
            new BasicUsername('foo'),
            'foo@bar.com',
            new Password('hashed', 'mysalt'),
            new \DateTime('now')
        );

        $this->commandBus->subscribe($this->commandHandler);
        $this->commandBus->dispatch($registerUserCommand);
    }
}
