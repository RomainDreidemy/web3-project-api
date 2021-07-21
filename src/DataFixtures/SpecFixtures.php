<?php

namespace App\DataFixtures;

use App\Entity\Familly;
use App\Entity\SensorType;
use App\Entity\Spec;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class SpecFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private EntityManagerInterface $manager){}

    public function load(ObjectManager $manager)
    {
        $sensorTypes = $this->manager->getRepository(SensorType::class)->findAll();
        $families = $this->manager->getRepository(Familly::class)->findAll();

        foreach ($sensorTypes as $sensorType) {
            foreach ($families as $family) {
                $spec = (new Spec())
                    ->setMin($min = random_int(20, 70))
                    ->setMax($min + 10)
                    ->setSensorType($sensorType)
                    ->setFamily($family);

                $manager->persist($spec);
            }
        }

        $manager->flush();
    }



    public function getDependencies()
    {
        return [
            FamilyFixtures::class,
            SensorTypeFixtures::class
        ];
    }
}
