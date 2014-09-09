<?php

namespace Milio\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form for registering new users.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RegisterUserFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('username', 'text', ['label' => 'form_register_label.username']);
        $builder->add('email', 'text', ['label' => 'form_register_label.email']);

        $builder->add('plainPassword', 'repeated', [
            'first_options' => ['label' => 'form_register_label.password'],
            'second_options' => ['label' => 'form_register_label.password_repeat'],
            'type' => 'password',
            'invalid_message' => 'validate.password_no_match',
        ]);

        $builder->add('register', 'submit', [
            'attr' => ['class' => "btn btn-primary"],
            'label' => 'form_register_label.register_button'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'MilioUserBundle',
                'data_class' => 'Milio\UserBundle\Form\Model\RegisterUserFormModel',
                'intention' => 'register',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'milio_user_register_user';
    }
}

