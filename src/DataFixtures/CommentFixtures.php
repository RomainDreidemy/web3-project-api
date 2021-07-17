<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $modules = $manager->getRepository(Module::class)->findAll();

        for ($i = 0; $i < 4; $i++) {
            $comment = (new Comment())
                ->setText('Ceci est un commentaire.')
                ->setModule($faker->randomElement($modules))
            ;

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModuleFixtures::class
        ];
    }
}
