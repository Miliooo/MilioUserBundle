<?php

namespace Milio\UserBundle\Form\Model;

/**
 * The form model for registering new users.
 *
 * Ideally we would want that to be our RegisterUserCommand model.
 * But that caused some problems and instead of trying to fight the form component we just use a simpler model and
 * create the command in our controllers ourselves.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserFormModel
{
    public $username;

    public $email;

    public $plainPassword;
}
