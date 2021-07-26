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

        $actionConditions = json_decode(file_get_contents(__DIR__ . '/datas/actions.json'), true);

        foreach ($actionConditions as $actionCondition) {
            $sensorType = $this->manager->getRepository(SensorType::class)->findOneBy(['name' => $actionCondition['SensorType']]);

            $family = $this->manager->getRepository(Familly::class)->findOneBy(['name' => $actionCondition['Family']]);

            $action = $this->manager->getRepository(Action::class)->findOneBy(['name' => trim($actionCondition['Title'])]);

            if(!is_null($sensorType) && !is_null($family) && !is_null($action)){
                $ac = (new ActionCondition())
                    ->setFamily($family)
                    ->setSensorType($sensorType)
                    ->setOperator($actionCondition['Operator'])
                    ->setValue(floatval($actionCondition['Value']))
                    ->addAction($action)
                ;

                $manager->persist($ac);
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
