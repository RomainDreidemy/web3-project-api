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
        $sensorTypes = [
            ['name' => 'Température de l\'air', 'unit' => '°C', 'influxId' => 'Air temperature'],
            ['name' => 'Température de l\'eau', 'unit' => '°C', 'influxId' => 'Water temperature'],
            ['name' => 'Qualité de l\'eau', 'unit' => 'mS/cm', 'influxId' => 'EC'],
            ['name' => 'pH', 'unit' => 'pH', 'influxId' => 'PH'],
            ['name' => 'Luminosité', 'unit' => 'lux', 'influxId' => 'Luminosity'],
            ['name' => 'Humidité', 'unit' => '%', 'influxId' => 'Humidity'],
        ];

        foreach ($sensorTypes as $sensorType) {
            $s = (new SensorType())
                ->setName($sensorType['name'])
                ->setUnit($sensorType['unit'])
                ->setInflexId($sensorType['influxId']);

            $manager->persist($s);
        }

        $manager->flush();
    }
}
