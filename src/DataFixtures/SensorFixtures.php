<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Sensor;
use App\Entity\SensorType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class SensorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sensorTypes = $manager->getRepository(SensorType::class)->findAll();
        $modules = $manager->getRepository(Module::class)->findAll();

        foreach ($modules as $module) {
            foreach ($sensorTypes as $sensorType) {
                $sensor = (new Sensor())
                    ->setType($sensorType)
                    ->setModule($module)
                    ->setIdInflux(Uuid::v4())
                ;

                $manager->persist($sensor);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SensorTypeFixtures::class,
            ModuleFixtures::class
        ];
    }
}
