<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Utilisateur standard
       $user = new User();
$user->setEmail('user@bibliotech.fr');
$user->setFirstName('Alice');
$user->setLastName('Martin');
$user->setRoles(['ROLE_USER']);
$user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
$manager->persist($user);


        $manager->persist($user);

        // Administrateur
$admin = new User();
$admin->setEmail('admin@bibliotech.fr');
$admin->setFirstName('Bob');
$admin->setLastName('Admin');
$admin->setRoles(['ROLE_ADMIN']);
$admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
$manager->persist($admin); 
        $manager->persist($admin);



        // bibliothecaire
$libraire = new User();
$libraire->setEmail('libraire@bibliotech.fr');
$libraire->setFirstName('Dany');
$libraire->setLastName('cool');
$libraire->setRoles(['ROLE_LIBRARIAN']);
$libraire->setPassword($this->passwordHasher->hashPassword($libraire, 'libraire123'));
$manager->persist($libraire); 
        $manager->persist($libraire);


        $manager->flush();
    }
}