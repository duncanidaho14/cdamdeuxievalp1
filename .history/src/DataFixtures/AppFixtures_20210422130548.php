<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create('FR-fr');
        $users = [];
        
        for ($i=0; $i < 15; $i++) { 
            $user = new User();

            $user->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setIsVerified(true)
                ->set
            ;

            $manager->persist($user);
            $users[] = $user;
        }
        
        for ($pro=0; $pro < 50; $pro++) { 
            $produit = new Produit();

            $produit->setTitre($faker->name())
                    ->setPrix($faker->numberBetween(1, 1000))
                    ->setUserOwner($user)
            ;

            $manager->persist($produit);

            for ($ima=1; $ima < 5; $ima++) { 
                $image = new Image();

                $image->setTitre($faker->name())
                    ->setUrl($faker->imageUrl())
                    ->setProduit($produit)
                ;

                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
