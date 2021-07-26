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
    public function load(ObjectManager $manager)
    {
        $specs = json_decode(file_get_contents(__DIR__ . '/datas/specs.json'), true);

        foreach ($specs as $spec) {
            $s = (new Spec())
                ->setFamily($manager->getRepository(Familly::class)->findOneBy(['name' => $spec['Family']]))
                ->setSensorType($manager->getRepository(SensorType::class)->findOneBy(['name' => $spec['SensorType']]))
                ->setMin(floatval($spec['min']))
                ->setMax(floatval($spec['max']))
            ;

            $manager->persist($s);
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
