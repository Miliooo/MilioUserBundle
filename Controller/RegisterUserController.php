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
use Milio\User\Services\Password\PasswordServiceInterface;

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
     * @var PasswordServiceInterface
     */
    private $passwordService;

    /**
     * @param FormFactoryInterface     $formFactory
     * @param EngineInterface          $templating
     * @param CommandBusInterface      $commandBus
     * @param CommandHandlerInterface  $commandHandler
     * @param PasswordServiceInterface $passwordService
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EngineInterface $templating,
        CommandBusInterface $commandBus,
        CommandHandlerInterface $commandHandler,
        PasswordServiceInterface $passwordService
    ) {
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->commandBus = $commandBus;
        $this->commandHandler = $commandHandler;
        $this->passwordService = $passwordService;
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
        $salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $password = $this->passwordService->getEncodedPassword('raw', 'my_hash');

        $registerUserCommand = new RegisterUserCommand(
            new StringUserId('5'),
            new BasicUsername('foo'),
            'foo@bar.com',
            new Password($password, $salt),
            new \DateTime('now')
        );

        $this->commandBus->subscribe($this->commandHandler);
        $this->commandBus->dispatch($registerUserCommand);
    }
}
