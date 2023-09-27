<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{/* in Fixture a second argument cannot be injected in the action in opposit to what we have in the controllers. 
    So to make fake data for user registration e need to add an empty constructor as below to inject UserPasswordHasher */
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('john@test.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )
        );
        $manager->persist($user2);

        // $product = new Product();
        // $manager->persist($product);
        $microPost1 = new MicroPost(); #after writing this, we should import 
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland!');
        $microPost1->setCreated(new DateTime()); #DateTime hsould be imported
        $microPost1->setAuthor($user1);
        $manager->persist($microPost1);

        $microPost2 = new MicroPost(); #after writing this, we should import 
        $microPost2->setTitle('Welcome to US!');
        $microPost2->setText('Welcome to US!');
        $microPost2->setCreated(new DateTime()); #DateTime hsould be imported
        $microPost2->setAuthor($user2);
        $manager->persist($microPost2);

        $microPost3 = new MicroPost(); #after writing this, we should import 
        $microPost3->setTitle('Welcome to Germany!');
        $microPost3->setText('Welcome to Germany!');
        $microPost3->setCreated(new DateTime()); #DateTime hsould be imported
        $microPost3->setAuthor($user1);
        $manager->persist($microPost3);

        $manager->flush();
        //To execute sending the above fake data to the database wew need to run this command: symfony console doctrine:fixtures:load
    }
}
