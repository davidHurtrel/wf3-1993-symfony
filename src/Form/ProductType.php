<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                // 'required' => true // pas nécessaire, required vaut true par défaut
                // 'label' => 'Nom' // c'est du visuel, c'est mieux dans les templates
                'attr' => [
                    // 'placeholder' => 'Ex. David', // c'est du visuel, c'est mieux dans les templates
                    'maxlength' => 100
                ]
            ])
            ->add('abstract', TextType::class, [
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'maxlength' => 2000
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 99999,
                    'step' => 1
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 9999.99,
                    'step' => 0.01
                ]
            ])
            ->add('min_players', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 99,
                    'step' => 1
                ]
            ])
            ->add('max_players', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 999,
                    'step' => 1
                ]
            ])
            ->add('minimum_age', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 21,
                    'step' => 1
                ]
            ])
            ->add('duration', TimeType::class, [
                'required' => false,
                'placeholder' => '00'
            ])
            ->add('editor', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 45
                ]
            ])
            ->add('theme', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 45
                ]
            ])
            ->add('mecanism', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('img1', FileType::class, [
                'required' => false,
                'mapped' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). Maximum autorisé : {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format {{ types }}.'
                    ])
                ]
            ])
            ->add('alt1', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('img2', FileType::class, [
                'required' => false,
                'mapped' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). Maximum autorisé : {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format {{ types }}.'
                    ])
                ]
            ])
            ->add('alt2', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('img3', FileType::class, [
                'required' => false,
                'mapped' => false,
                'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). Maximum autorisé : {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format {{ types }}.'
                    ])
                ]
            ])
            ->add('alt3', TextType::class, [
                'required' => false,
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                // 'multiple' => true, // pour autoriser la sélection de plusieurs catégories
                // 'expanded' => true, // affichage sous forme de boutons checkbox (ou radio si multiple à false)
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                } // constructeur de requête (ici pour récupérer les catégories triés par ordre alphabétique)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
