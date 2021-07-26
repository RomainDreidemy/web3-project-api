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
        $families = json_decode(file_get_contents(__DIR__ . '/datas/families.json'), true);

        foreach ($families as $family) {
            $family = (new Familly())
                ->setName($family['Name'])
            ;

            $manager->persist($family);
        }

        $manager->flush();
    }
}
