<?php

namespace App\DataFixtures;

use App\Entity\Familly;
use App\Entity\Module;
use App\Entity\SensorType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class SensorTypeFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $sensorTypes = json_decode(file_get_contents(__DIR__ . '/datas/sensorTypes.json'), true);

        foreach ($sensorTypes as $sensorType) {
            $s = (new SensorType())
                ->setName($sensorType['Name'])
                ->setUnit($sensorType['Unit'])
                ->setInflexId($sensorType['influxId'])
                ->setIconPath($sensorType['Icon']);

            $manager->persist($s);
        }

        $manager->flush();
    }
}
