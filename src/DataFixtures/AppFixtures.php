<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $microPost1 = new MicroPost(); #after writing this, we should import 
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland!');
        $microPost1->setCreated(new DateTime()); #DateTime hsould be imported
        $manager->persist($microPost1);

        $microPost2 = new MicroPost(); #after writing this, we should import 
        $microPost2->setTitle('Welcome to US!');
        $microPost2->setText('Welcome to US!');
        $microPost2->setCreated(new DateTime()); #DateTime hsould be imported
        $manager->persist($microPost2);

        $microPost3 = new MicroPost(); #after writing this, we should import 
        $microPost3->setTitle('Welcome to Germany!');
        $microPost3->setText('Welcome to Germany!');
        $microPost3->setCreated(new DateTime()); #DateTime hsould be imported
        $manager->persist($microPost3);

        $manager->flush();
    }
}
