<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");
        $user = new User();
        $user->setEmail("admin@admin.com")
            ->setPrenom($faker->firstName())
            ->setNom($faker->lastName())
            ->setAPropos("hi i m admin of this web site")
            ->setTelephone($faker->phoneNumber())
            ->setInstagram('instagram');

        $encoded = $this->encoder->hashPassword($user, 'password');
        $user->setPassword($encoded);
        $manager->persist($user);


        for ($i = 0; $i < 10; $i++) {

            $blogpost = new Blogpost();
            $blogpost->setTitle($faker->words(3, true))
                ->setContenu($faker->text(350))
                ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                ->setSlug($faker->slug(3))
                ->setUser($user);
            $manager->persist($blogpost);
        }

        for ($i = 0; $i < 5; $i++) {
            $categorie = new Categorie();

            $categorie->setNom($faker->word())
                ->setDescription($faker->text(10))
                ->setSlug($faker->slug());
            $manager->persist($categorie);


            for ($j = 0; $j < 2; $j++) {
                $projet = new Projet();

                $projet->setNom($faker->name())
                    ->setDescription($faker->text(100))
                    ->setCreatedAt($faker->dateTimeBetween("-6 month", 'now'))
                    ->setDateRealisation($faker->dateTimeBetween("-6 month", 'now'))
                    ->setEnVente($faker->randomElement([true, false]))
                    ->setFile('/assets/images/blog-1.jpg')
                    ->addCategorie($categorie)
                    ->setPortfolio($faker->randomElement([true, false]))
                    ->setSlug($faker->slug(3))
                    ->setPrix($faker->randomFloat([3, 200, 9999]))
                    ->setUser($user);
                $manager->persist($projet);
            }
        }










        $manager->flush();
    }
}
