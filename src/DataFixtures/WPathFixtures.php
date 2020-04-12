<?php

namespace App\DataFixtures;

use App\Entity\Path;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class WPathFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $path1 = new Path();
        $path1->setDateTime(new \DateTime("2020-05-12 20:20:00", new \DateTimeZone("Europe/London")));
        $path1->setSeats(4);
        $path1->setDeparture($manager->merge($this->getReference('nantes')));
        $path1->setDestination($manager->merge($this->getReference('tours')));
        $path1->setDriver($manager->merge($this->getReference('user')));
        $path1->setPrice(45);

        $path2 = new Path();
        $path2->setDateTime(new \DateTime("2020-01-01 20:20:00", new \DateTimeZone("Europe/London")));
        $path2->setSeats(12);
        $path2->setDeparture($manager->merge($this->getReference('nantes')));
        $path2->setDestination($manager->merge($this->getReference('tours')));
        $path2->setDriver($manager->merge($this->getReference('user')));
        $path2->setPrice(120);

        $manager->persist($path1);
        $manager->persist($path2);

        $manager->flush();
    }
}