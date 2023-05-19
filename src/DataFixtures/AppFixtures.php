<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Commentaire;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create("FR-fr");
        for($i = 0; $i <1000; $i++) {
            $produit = new Produit();
            $produit->setNom($faker->firstName);
            $produit->setDescription($faker->description);
            $produit->setImage($faker->image);
            $produit->setStock($faker->stock);
            $manager->persist($produit);

            for($c = 0; $c <1000; $c++) {
                $commentaire = new Commentaire();
                $commentaire->setTitre($faker->titre);
                $commentaire->setContenu($faker->contenu);
                $manager->persist($commentaire);
            }
        }

        $manager->flush();
    }
}
