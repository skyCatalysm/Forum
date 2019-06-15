<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                    'placeholder' => 'Email Address',
                    'class' => 'input is-rounded'
                ]
            ])
            ->add('password',PasswordType::class,[
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'input is-rounded'
                ]
            ])
            ->add('password2',PasswordType::class,[
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Retype Password',
                    'class' => 'input is-rounded'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
