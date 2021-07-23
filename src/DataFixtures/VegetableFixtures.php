<?php

namespace App\DataFixtures;

use App\Entity\Vegetable;
use App\Repository\FamillyRepository;
use App\Repository\VegetableRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VegetableFixtures extends Fixture
{
    public function __construct(private FamillyRepository $famillyRepository){}

    public function load(ObjectManager $manager)
    {
        $vegetables = json_decode(file_get_contents(__DIR__ . '/datas/vegetables.json'), true);

        foreach ($vegetables as $vegetable){
            if(!empty(trim($vegetable['Property']))){
                $v = (new Vegetable())
                    ->setName($vegetable['Property'])
                    ->setFamily($this->famillyRepository->findOneBy(['name' => $vegetable['Family']]))

                    ->setWater(intval($vegetable['Water']))
                    ->setFiber(intval($vegetable['Fiber']))
                    ->setGlucose(intval($vegetable['Glucose']))
                    ->setProtein(intval($vegetable['Protein']))
                    ->setLipid(intval($vegetable['Lipid']))

                    ->setIntroText($vegetable['Intro'])
                    ->setCultureText($vegetable['Culture'])
                    ->setEntretienText($vegetable['Entretien'])
                    ->setRecolteText($vegetable['Recolte'])

                    ->setCycle($vegetable['Cycle'])
                    ->setExposition($vegetable['Exposition'])
                    ->setYield($vegetable['Rendement'])
                    ->setSvg($vegetable['svg'])

                    ->setCultureStart($vegetable['start_culture'])
                    ->setCultureEnd($vegetable['end_culture'])
                    ->setRecolteStart($vegetable['start_recolte'])
                    ->setRecolteEnd($vegetable['end_recolte'])
                ;

                $manager->persist($v);
            }
        }

        $manager->flush();
    }
}
