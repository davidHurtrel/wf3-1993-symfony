<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'attr' => [
                    'maxlength' => 45
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'maxlength' => 45
                ]
            ])
            ->add('company', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'maxlength' => 100
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    '-- choix --' => '',
                    'commande' => 'commande',
                    'livraison' => 'livraison',
                    'service après-vente' => 'SAV',
                    'signaler un bug' => 'bug',
                    'votre compte' => 'compte',
                    'autre' => 'divers',
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'minlength' => 50,
                    'maxlength' => 3000
                ],
                'help' => '3000 caractères maximum'
            ])
            ->add('attachment', FileType::class, [
                'required' => false,
                'help' => 'image ou document PDF - 2 Mo maximum',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}',
                        'mimeTypes' => [
                            'image/*',
                            'application/pdf'
                        ],
                        'mimeTypesMessage' => 'Le type de fichier est invalide ({{ type }}). Les types autorisés sont {{ types }}'
                    ])
                ]
            ])
            ->add('honeypot', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
