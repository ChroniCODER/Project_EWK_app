<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $purchaseDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2022-01-01 12:00:00');

        $product1 = new Product();
        
        $product1->setName('NesPresso DEMO');
        $product1->setPurchaseDate($purchaseDate);
        $product1->setImage('/images/nespresso.jpg');

        $manager->persist($product1);

        $manager->flush();
    }
}
