<?php

namespace App\DataFixtures;

use App\Entity\SensorType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SensorTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sensorTypes = [
            ['name' => 'Température de l\'air', 'unit' => '°C'],
            ['name' => 'Température de l\'eau', 'unit' => '°C'],
            ['name' => 'Hygrométrie', 'unit' => '%'],
            ['name' => 'pH', 'unit' => '%'],
            ['name' => 'Luminosité', 'unit' => ''],
        ];

        foreach ($sensorTypes as $sensorType){
            $s = (new SensorType())
                ->setName($sensorType['name'])
                ->setUnit($sensorType['unit'])
            ;

            $manager->persist($s);
        }

        $manager->flush();
    }
}
