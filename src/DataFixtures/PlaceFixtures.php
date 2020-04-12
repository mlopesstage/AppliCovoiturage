<?php

namespace App\DataFixtures;

use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PlaceFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $place1 = new Place();
        $place1->setName("Nantes");

        $place2 = new Place();
        $place2->setName("Tours");

        $place3 = new Place();
        $place3->setName("Rennes");

        $place4 = new Place();
        $place4->setName("Angers");

        $place5 = new Place();
        $place5->setName("Paris");

        $manager->persist($place1);
        $manager->persist($place2);
        $manager->persist($place3);
        $manager->persist($place4);
        $manager->persist($place5);
        $manager->flush();

        $this->addReference('nantes', $place1);
        $this->addReference('tours', $place2);
        $this->addReference('rennes', $place3);
        $this->addReference('angers', $place4);
        $this->addReference('paris', $place5);
    }
}