<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\BelleHistoire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class BelleHistoireFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger)
    {}

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $now = new \DateTimeImmutable();
    
        for($bh=1; $bh<=50; $bh++){
            $histoire = new BelleHistoire();
            $histoire->setTitre($faker->words(10,true));
            $histoire->setSlug($this->slugger->slug($histoire->getTitre())->lower());
            $histoire->setDateCreation($now);
            $histoire->setPhoto($faker->imageUrl());
            $histoire->setTexte($faker->realText(3000));
            $histoire->setEtat(mt_rand(0,2)===1 ? BelleHistoire::STATES[0] : BelleHistoire::STATES[1]);
            // $memorial->setCategorieAnimal();
            $histoire->setAuteur($this->getReference('auteur'));
            $manager->persist($histoire);
    
            $manager->flush();            
        }

    }
}
