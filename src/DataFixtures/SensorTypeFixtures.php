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
            ['name' => 'Température de l\'air', 'unit' => '°C', 'influxId' => 'Air temperature', 'icon_path' => '/images/sensor_icons/Temperatur_dair.svg'],
            ['name' => 'Température de l\'eau', 'unit' => '°C', 'influxId' => 'Water temperature', 'icon_path' => '/images/sensor_icons/Temperatur_deau.svg'],
            ['name' => 'Qualité de l\'eau', 'unit' => 'mS/cm', 'influxId' => 'EC', 'icon_path' => '/images/sensor_icons/Nurriture.svg'],
            ['name' => 'pH', 'unit' => 'pH', 'influxId' => 'PH', 'icon_path' => '/images/sensor_icons/Ph.svg'],
            ['name' => 'Luminosité', 'unit' => 'lux', 'influxId' => 'Luminosity', 'icon_path' => '/images/sensor_icons/Lumiere.svg'],
            ['name' => 'Humidité', 'unit' => '%', 'influxId' => 'Humidity', 'icon_path' => '/images/sensor_icons/Huminite_Air.svg'],
        ];

        foreach ($sensorTypes as $sensorType) {
            $s = (new SensorType())
                ->setName($sensorType['name'])
                ->setUnit($sensorType['unit'])
                ->setInflexId($sensorType['influxId'])
                ->setIconPath($sensorType['icon_path']);

            $manager->persist($s);
        }

        $manager->flush();
    }
}
