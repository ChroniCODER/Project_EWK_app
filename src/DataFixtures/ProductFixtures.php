<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const NESPRESSO_DEMO = 'NESPRESSO_DEMO';
    public const FRIGO_DEMO = 'FRIGO_DEMO';


    public function load(ObjectManager $manager): void
    {

        $purchaseDate1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2022-01-01 12:00:00');
        $purchaseDateAdded1 = \DateTime::createFromFormat('Y-m-d H:i:s', '2022-01-01 12:00:00');
        $warrantyDuration = 2;
        $dateInterval = new DateInterval('P' . $warrantyDuration . 'Y');
        $expirationDate1 = $purchaseDateAdded1->add($dateInterval);

        $product1 = new Product();
        $product1->setName('NesPresso DEMO');
        $product1->setPurchaseDate($purchaseDate1);
        $product1->setWarrantyDuration($warrantyDuration);
        $product1->setExpirationDate($expirationDate1);
        $product1->setImage('/images/nespresso.jpg');
        $this->addReference(self::NESPRESSO_DEMO, $product1);
        $manager->persist($product1);

        $purchaseDate2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-03-26 12:00:00');
        $purchaseDateAdded2 = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-03-26 12:00:00');
        $warrantyDuration = 2;
        $dateInterval = new DateInterval('P' . $warrantyDuration . 'Y');
        $expirationDate2 = $purchaseDateAdded2->add($dateInterval);
        
        $product2 = new Product();
        $product2->setName('Frigo maison DEMO');
        $product2->setPurchaseDate($purchaseDate2);
        $product2->setWarrantyDuration($warrantyDuration);
        $product2->setExpirationDate($expirationDate2);
        $product2->setImage('/images/frigo_demo.jpg');
        $this->addReference(self::FRIGO_DEMO, $product2);
        $manager->persist($product2);

        $manager->flush();
    }
}
