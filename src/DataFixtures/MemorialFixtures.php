<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\AnimalMemorial;
use App\Entity\CategorieAnimal;
use App\Repository\CategorieAnimalRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MemorialFixtures extends Fixture
{

    public function load(ObjectManager $manager,): void
    {

    $faker = Factory::create('fr_FR');
    $now = new \DateTimeImmutable();

    for($memo=1; $memo<=50; $memo++){
        $memorial = new AnimalMemorial();
        $memorial->setNom($faker->firstName);
        $memorial->setSexe('Femelle');
        $memorial->setDateDeces($now);
        $memorial->setLieu($faker->city);
        $memorial->setPhoto($faker->imageUrl());
        $memorial->setPresentation($faker->realText(1000));
        $memorial->setChosesAimees($faker->realText(1000));
        $memorial->setChosesDetestees($faker->realText(1000));
        $memorial->setHistoire($faker->realText(1000));
        // $memorial->setCategorieAnimal();
        $memorial->setAuteur($this->getReference('auteur'));
        $manager->persist($memorial);

        $manager->flush();            
    }
        
    }
}
