<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\AnimalMemorial;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

    }
}
