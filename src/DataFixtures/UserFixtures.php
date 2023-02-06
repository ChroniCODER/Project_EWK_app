<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$.FCZSM4Bi2L1hpAE1UtIaOZx4XbNGvQAFVhcQ9EXTaPjVm0UBWM7S');
        $manager->persist($user);

        $manager->flush();
    }
}
