<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Dicton;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $coucou = random_int(10, 500);
        for ($i = 0;$i < 6; $i++){
            $author = new Author();
            $author->setName($faker->name());

            for ($j = 0; $j < $coucou; $j++){
                $dicton = new Dicton();
                $dicton->setCreatedAt($faker->dateTimeBetween('-5 years'));
                $dicton->setContent($faker->text());
                $dicton->setAuthor($author);
                $manager->persist($dicton);
            }
            $manager->persist($author);
        }


        $manager->flush();
    }
}
