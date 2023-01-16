<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'maxLength' => 100
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'mapped' => false,
                'choices' => [
                    'utilisateur' => '',
                    'administrateur' => 'ROLE_ADMIN',
                    'super administrateur' => 'ROLE_SUPER_ADMIN'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner un mot de passe'
                        ]),
                        new PasswordStrength([
                            'minLength' => 8,
                            'tooShortMessage' => 'Le mot de passe doit contenir au moins {{length}} caractères.',
                            'minStrength' => 4,
                            'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caratère spécial.'
                        ])
                    ] 
                ],
                'second_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de confirmer le mot de passe'
                        ])
                    ]
                ]
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'maxlength' => 15
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
