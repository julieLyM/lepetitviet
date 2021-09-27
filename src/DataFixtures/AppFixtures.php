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
            ->setEmail('juju@juju.ju')
            ->setPassword('demo')
            ->setPhone(0160606060)
            ->setAdress('10 rue de paris')
            ->setCity('Paris')
            ->setZipcode(75001)
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTime());

        $manager->persist($user);

        $politique = new Category();
        $politique->setName('Politique')->setSlug('politique');
        $manager->persist($politique);

        $sante = new Category();
        $sante->setName('Santé')->setSlug('sante');
        $manager->persist($sante);

        $manager->flush();



    }
}
