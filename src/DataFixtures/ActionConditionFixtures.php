<?php

namespace App\DataFixtures;

use App\Entity\Action;
use App\Entity\ActionCondition;
use App\Entity\Familly;
use App\Entity\SensorType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActionConditionFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private EntityManagerInterface $manager){}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $sensorTypes = $this->manager->getRepository(SensorType::class)->findAll();
        $families = $this->manager->getRepository(Familly::class)->findAll();
        $actions = $this->manager->getRepository(Action::class)->findAll();

        $operators = ['<', '>', '='];

        foreach ($families as $family){
            foreach ($sensorTypes as $sensorType){
                $condition = (new ActionCondition())
                    ->setFamily($family)
                    ->setSensorType($sensorType)
                    ->setOperator($faker->randomElement($operators))
                    ->setValue(random_int(5, 100))
                ;

                for ($i = 0; $i < random_int(1, 4); $i++){
                    $condition->addAction($faker->randomElement($actions));
                }

                $manager->persist($condition);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SensorTypeFixtures::class,
            ActionFixtures::class
        ];
    }
}
