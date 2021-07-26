<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enums\UserRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'admin@domain.net',
                'roles' => [UserRoles::ROLE_ADMIN],
                'password' => 'admin'
            ],
            [
                'email' => 'school@domain.net',
                'roles' => [UserRoles::ROLE_SCHOOL],
                'password' => 'school'
            ],
        ];

        foreach ($users as $user) {
            $u = new User();
            $u
                ->setEmail($user['email'])
                ->setRoles($user['roles'])
                ->setPassword($this->hasher->hashPassword($u, $user['password']));

            $manager->persist($u);
        }

        $manager->flush();
    }
}
