<?php

namespace Milio\UserBundle\Services;

use Milio\User\Services\Password\PasswordServiceInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Implementation which uses the symfony security component.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class SecurityPasswordService implements PasswordServiceInterface
{
    /**
     * Constructor.
     *
     * @param PasswordEncoderInterface $passwordEncoder
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getEncodedPassword($raw, $salt)
    {
        return $this->passwordEncoder->encodePassword($raw, $salt);
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $this->passwordEncoder->isPasswordValid($encoded, $raw, $salt);
    }
}
