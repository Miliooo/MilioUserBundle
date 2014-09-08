<?php

namespace Milio\UserBundle\Model\Read;

use Milio\User\Domain\Read\Model\UserRead as BaseUserRead;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

/**
 * Class UserRead
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRead extends BaseUserRead implements SecurityUserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [new Role('ROLE_USER')];
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }
}
