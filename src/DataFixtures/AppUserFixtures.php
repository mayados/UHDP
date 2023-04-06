<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {}
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

       for($usr=1; $usr<=50; $usr++){
           $user = new User();
           $user->setEmail($faker->email);
           $user->setPseudo($faker->firstName);
           $user->setPassword(
               $this->passwordEncoder->hashPassword($user,'user')
           );
           $user->setIsVerified(true);
           $user->setBannir(false);
           // $user->setRoles(['ROLE_USER']);

           $this->setReference('auteur', $user);
           $manager->persist($user);           
           $manager->flush();
       }
    }
}
