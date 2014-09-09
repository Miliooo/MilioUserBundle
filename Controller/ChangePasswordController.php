<?php

namespace Milio\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ChangePasswordController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ChangePasswordController
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @return Response
     */
    public function showAction()
    {
        return $this->templating->renderResponse('MilioUserBundle:Settings:change_password.html.twig');
    }
}
