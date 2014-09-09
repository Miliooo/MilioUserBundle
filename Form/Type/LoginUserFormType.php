<?php

namespace Milio\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LoginUserFormType
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class LoginUserFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', ['label' => 'form_register_label.username']);
        $builder->add('password', 'password', ['label' => 'form_register_label.password']);
        $builder->add('submit', 'submit', ['label' => 'form_register_label.submit_login']);
        $builder->setAction('login_check');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'MilioUserBundle',
                'intention' => 'login_user'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'milio_user_login_user';
    }
}
