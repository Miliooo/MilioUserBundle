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
use Milio\User\Services\Password\PasswordServiceInterface;
use Milio\UserBundle\Form\Model\RegisterUserFormModel;
use Milio\User\Domain\ValueObjects\UserId;

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
     * Constructor.
     *
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
        $form = $this->formFactory->create(new RegisterUserFormType(), new RegisterUserFormModel());

        return $this->templating->renderResponse('MilioUserBundle:Registration:registration.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function updateAction(Request $request)
    {
        $form = $this->formFactory->create(new RegisterUserFormType(), new RegisterUserFormModel());
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->templating->renderResponse('MilioUserBundle:Registration:registration.html.twig', ['form' => $form->createView()]);
        }

        /** @var RegisterUserFormModel $data */
        $data = $form->getData();


        $salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $password = $this->passwordService->getEncodedPassword($data->plainPassword, $salt);

        $registerUserCommand = new RegisterUserCommand(
            UserId::generate(),
            new BasicUsername($data->username),
            $data->email,
            new Password($password, $salt),
            new \DateTime()
        );

        $this->commandBus->subscribe($this->commandHandler);
        $this->commandBus->dispatch($registerUserCommand);

        return $this->templating->renderResponse('MilioUserBundle:Registration:registration_success.html.twig', ['data'=> $data]);
    }
}
