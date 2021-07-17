<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $manager
    ){}

    public function resetPassword(User $user ,string $newPassword): bool
    {
        $user->setPassword($this->hasher->hashPassword($user, $newPassword));

        $this->manager->persist($user);
        $this->manager->flush();

        return true;
    }
}