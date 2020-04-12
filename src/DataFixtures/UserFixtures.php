<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("user@user.fr");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $manager->persist($user);
        $user->setLastName("Jesappelle");
        $user->setFirstName("Groot");
        $user->setTheme("white");

        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $admin->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $admin->setLastName("Leptit");
        $admin->setFirstName("Corona");
        $admin->setTheme("white");

        $manager->flush();

        $this->addReference('user', $user);
    }
}