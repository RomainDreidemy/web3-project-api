<?php

namespace App\DataFixtures;

use App\Entity\Familly;
use App\Entity\Module;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $families = $manager->getRepository(Familly::class)->findAll();
        $users = $this->userRepository->getSchoolUsers();

        $modules = [
            ['name' => 'bac de madame Biboule' ,'nodeId' => "12345678"],
            ['name' => 'bac de monsieur Biboule' ,'nodeId' => "7654321"],
            ['name' => 'bac de madame Courtemanche' ,'nodeId' => "7654320"],
            ['name' => 'Bac de monsieur Duchêne' ,'nodeId' => "7654319"]
        ];



        foreach ($modules as $module) {
            $m = (new Module())
                ->setName($module['name'])
                ->setFamilly($faker->randomElement($families))
                ->setUser($faker->randomElement($users))
                ->setInfluxId($module['nodeId']);

            $manager->persist($m);
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
