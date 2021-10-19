<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstname('julie')
            ->setLastname('ly')
            ->setEmail('julie@ly.fr')
            ->setPassword('coucou')
            ->setPhone(0160606060)
            ->setAdress('10 rue de paris')
            ->setCity('Paris')
            ->setZipcode(75001)
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTime());

        $manager->persist($user);

        $manager->flush();



    }
}
