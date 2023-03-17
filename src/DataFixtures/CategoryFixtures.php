<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const CATEGORY_HOME = 'CATEGORY_HOME';
    public const CATEGORY_HIFI= 'CATEGORY_HIFI';

    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('Home');
        $manager->persist($category1);
        $this->addReference(self::CATEGORY_HOME, $category1);

        $category2 = new Category();
        $category2->setName('Vehicle');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Hi-Fi');
        $manager->persist($category3);
        $this->addReference(self::CATEGORY_HIFI, $category3);


        $category4 = new Category();
        $category4->setName('Jewelry');
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName('Kidz');
        $manager->persist($category5);

        $category6 = new Category();
        $category6->setName('Others');
        $manager->persist($category6);

        $manager->flush();
    }
}
