<?php

namespace App\DataFixtures;

use App\Entity\Familly;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FamilyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 4; $i++) {
            $family = (new Familly())
                ->setName($faker->name)
            ;

            $manager->persist($family);
        }

        $manager->flush();
    }
}
