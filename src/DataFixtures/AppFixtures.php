<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1
            ->setName('Stratégie')
            ->setSlug('strategie')
            ->setDescription(null)
            ->setImg(null);
        $manager->persist($category1);

        for ($i = 0; $i < 50; $i++) {
            $product1 = new Product();
            $product1
                ->setName('Azul')
                ->setSlug('azul')
                ->setQuantity(19)
                ->setAbstract('Jouez avec les beautés des Azulejos portugais... Azul est un jeu de stratégie et de réflexion pour 2 à 4 joueurs.')
                ->setDescription('Introduits par les Maures, les azulejos (carreaux de revêtement mural en faïence, originalement décorés de bleu ou polychromes) furent adoptés par les Portuguais au moment où leur roi Manuel 1er, durant une visite au palais de l\'Alhambra dans le sud de l\'Espagne, fut conquis par l’éblouissante beauté des tuiles décoratives. Manuel 1er ordonna la décoration immédiate, avec des tuiles semblables, des murs de son palais. Azul vous transporte au 16e  siècle, truelle en main, à embellir les murs du Palais Royal de Evora ! Azul vous invite à embellir les murs du Palais Royal de Evora en devenant artisan avec un jeu de tuiles très malin et dépaysant.')
                ->setDuration(null)
                ->setPrice(40.5)
                ->setMinimumAge(8)
                ->setMinPlayers(2)
                ->setMaxPlayers(4)
                ->setCategory($category1)
                ->setImg1('1673445035-1.jpg')
                ->setImg2('1673445035-2.jpg')
                ->setImg3('1673445035-3.jpg')
                ->setAlt1('texte alternatif image 1')
                ->setAlt2('texte alternatif image 2')
                ->setAlt3('texte alternatif image 3')
                ->setTheme('Portugal, tradition')
                ->setMecanism('optimisation, combinaison')
                ->setEditor('Next Move (Plan B Games)')
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($product1);
        }

        $manager->flush();
    }
}
