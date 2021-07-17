<?php

namespace App\DataFixtures;

use App\Entity\Familly;
use App\Entity\Module;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $families = $manager->getRepository(Familly::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $module = (new Module())
                ->setName($faker->randomElement([$faker->name, null]))
                ->setFamilly($faker->randomElement($families))
                ->setUser($faker->randomElement($users))
            ;

            $manager->persist($module);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            FamilyFixtures::class
        ];
    }
}
