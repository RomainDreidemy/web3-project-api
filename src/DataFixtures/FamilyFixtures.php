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
        $families = ['Légumes racines', 'Légumes fruits', 'Légumes feuilles', 'Légumes fleurs'];

        foreach ($families as $family) {
            $family = (new Familly())
                ->setName($family)
            ;

            $manager->persist($family);
        }

        $manager->flush();
    }
}
