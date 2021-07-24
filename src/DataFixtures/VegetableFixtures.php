<?php

namespace App\DataFixtures;

use App\Entity\Vegetable;
use App\Repository\FamillyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VegetableFixtures extends Fixture
{
    public function __construct(private FamillyRepository $famillyRepository)
    {
    }

    public function load(ObjectManager $manager)
    {
        $vegetables = json_decode(file_get_contents(__DIR__ . '/datas/vegetables.json'), true);

        foreach ($vegetables as $vegetable) {
            if (!empty(trim($vegetable['Property']))) {
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
                    ->setSvgPath($this->getSvgPath($vegetable))
                    ->setCultureStart($vegetable['start_culture'])
                    ->setCultureEnd($vegetable['end_culture'])
                    ->setRecolteStart($vegetable['start_recolte'])
                    ->setRecolteEnd($vegetable['end_recolte']);

                $manager->persist($v);
            }
        }

        $manager->flush();
    }

    private function getSvgPath($vegetable): string
    {
        $publicPath = '/images/vegetables/';
        $typeImage = '.svg';

        switch ($vegetable['Property']) {
            case 'Artichaut':
                return $this->getPathConcatenation($publicPath, 'artichaut', $typeImage);

            case 'Aubergine':
                return $this->getPathConcatenation($publicPath, 'aubergine', $typeImage);

            case 'Betterave':
                return $this->getPathConcatenation($publicPath, 'betterave', $typeImage);

            case 'Brocoli':
                return $this->getPathConcatenation($publicPath, 'brocoli', $typeImage);

            case 'Câpre':
                return $this->getPathConcatenation($publicPath, 'capre', $typeImage);

            case 'Carotte':
                return $this->getPathConcatenation($publicPath, 'carotte', $typeImage);

            case 'Chou-fleur':
                return $this->getPathConcatenation($publicPath, 'chou-fleur', $typeImage);

            case 'Citrouille':
                return $this->getPathConcatenation($publicPath, 'citrouille', $typeImage);

            case 'Courgette':
                return $this->getPathConcatenation($publicPath, 'courgette', $typeImage);

            case 'Epinard':
                return $this->getPathConcatenation($publicPath, 'epinard', $typeImage);

            case 'Gingembre':
                return $this->getPathConcatenation($publicPath, 'gingembre', $typeImage);

            case 'Haricot':
                return $this->getPathConcatenation($publicPath, 'haricot', $typeImage);

            case 'Laitue':
                return $this->getPathConcatenation($publicPath, 'laitue', $typeImage);

            case 'Mâche':
                return $this->getPathConcatenation($publicPath, 'mache', $typeImage);

            case 'Mangold':
                return $this->getPathConcatenation($publicPath, 'mangold', $typeImage);

            case 'Oignon':
                return $this->getPathConcatenation($publicPath, 'oignon', $typeImage);

            case 'Poivron':
                return $this->getPathConcatenation($publicPath, 'poivron', $typeImage);

            case 'Pomme de terre':
                return $this->getPathConcatenation($publicPath, 'pomme-de-terre', $typeImage);

            case 'Radis':
                return $this->getPathConcatenation($publicPath, 'radis', $typeImage);

            case 'Radicchio':
                return $this->getPathConcatenation($publicPath, 'radicchio', $typeImage);

            case 'Roquette':
                return $this->getPathConcatenation($publicPath, 'roquette', $typeImage);

            case 'Tomate':
                return $this->getPathConcatenation($publicPath, 'tomate', $typeImage);

            default:
                return '';
        }

    }

    private function getPathConcatenation($path, $name, $type): string
    {
        return $path . $name . $type;
    }
}
