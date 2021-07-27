<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $modules = $manager->getRepository(Module::class)->findAll();

        $this->createAndPersistFakeComment($manager, $modules[0], 'La première fraise mûre !!', 'https://res.cloudinary.com/hl4a3z5co/image/upload/v1627408346/dev/comments/hcmtte5ycidnzsaypaqe.jpg');
        $this->createAndPersistFakeComment($manager, $modules[0], 'Les racines des jeunes pousses ont bien poussé', 'https://res.cloudinary.com/hl4a3z5co/image/upload/v1627408348/dev/comments/gqjzypsvjfdwrjvfn5cc.jpg');
        $this->createAndPersistFakeComment($manager, $modules[0], 'Madame Perez qui pose à côté des plantes avant la récolte', 'https://res.cloudinary.com/hl4a3z5co/image/upload/v1627408349/dev/comments/iq6u5k9uzv0xmszm54ta.jpg');
        $this->createAndPersistFakeComment($manager, $modules[0], 'Aujourd\'hui on a planté de nouveaux semis. Il y a des tomates, des fraises et des concombres.');
        $this->createAndPersistFakeComment($manager, $modules[1], 'Aujourd\'hui on a renouvelé l\'eau des bacs et on a vu pourquoi c\'est important pour les plantes d\'avoir une eau de bonne qualité');
        $this->createAndPersistFakeComment($manager, $modules[1], 'Les laitues après 3 semaines', 'https://res.cloudinary.com/hl4a3z5co/image/upload/v1627408347/dev/comments/o7wuy5fhvqohkabvnhuz.jpg');

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModuleFixtures::class
        ];
    }

    private function createAndPersistFakeComment(ObjectManager $manager, Module $module, string $text, string $imageUrl = null): void
    {
        $faker = Factory::create();

        $comment = (new Comment())
            ->setText($text)
            ->setModule($module);

        if ($imageUrl) {
            $image = (new Image())
                ->setComment($comment)
                ->setCreatedAt(new \DateTimeImmutable($faker->dateTimeThisMonth()->format('Y-m-d H:i:s')))
                ->setFormat('jpg')
                ->setPublicId('blabla')
                ->setSecureUrl($imageUrl);

            $manager->persist($image);
            $comment->addImage($image);
        }

        $manager->persist($comment);
    }
}
