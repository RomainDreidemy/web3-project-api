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

        $nodeIds = ["12345678", "7654321", "7654320", "7654319"];

        foreach ($nodeIds as $nodeId) {
            $module = (new Module())
                ->setName($faker->word(4, true))
                ->setFamilly($faker->randomElement($families))
                ->setUser($faker->randomElement($users))
                ->setInfluxId($nodeId);

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
