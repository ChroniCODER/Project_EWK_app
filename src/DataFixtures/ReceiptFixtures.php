<?php

namespace App\DataFixtures;

use App\Entity\Receipt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReceiptFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $receipt1 = new Receipt();
        $receipt1->setImage('/images/ticket-de-caisse.jpg');
        $receipt1->setProduct($this->getReference(ProductFixtures::NESPRESSO_DEMO));
        $manager->persist($receipt1);

        $receipt2 = new Receipt();
        $receipt2->setImage('/images/receipt_fake.jpg');
        $receipt2->setProduct($this->getReference(ProductFixtures::FRIGO_DEMO));
        $manager->persist($receipt2);

        $receipt3 = new Receipt();
        $receipt3->setImage('/images/facture-store-fake.png');
        $receipt3->setProduct($this->getReference(ProductFixtures::STORE_DEMO));
        $manager->persist($receipt3);
        

        $manager->flush();
    }

    public function getDependencies()
    {

        return [
            ProductFixtures::class,
        ];
    }
}
