<?php

namespace App\DataFixtures;

use App\Entity\Action;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $actions = json_decode(file_get_contents(__DIR__ . '/datas/actions.json'), true);


        foreach ($actions as $action) {
            $alreadyExist = $manager->getRepository(Action::class)->findOneBy(['text' => $action['Actions']]);

            if(is_null($alreadyExist)) {
                $a = (new Action())
                    ->setName($action['Title'])
                    ->setText($action['Actions'])
                ;

                $manager->persist($a);
                $manager->flush();
            }
        }
    }
}
