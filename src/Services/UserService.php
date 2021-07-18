<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $manager,
        private MailerService $mailerService
    ){}

    public function resetPassword(string $token ,string $newPassword): bool
    {
        /** @var User|null $user */
        $user = $this->manager->getRepository(User::class)->findOneBy(['passwordToken' => $token]);

        if(is_null($user)){
           return false;
        }

        $user
            ->setPassword($this->hasher->hashPassword($user, $newPassword))
            ->setPasswordToken(null)
        ;

        $this->manager->persist($user);
        $this->manager->flush();

        return true;
    }

    public function generateToken(string $email): string|false
    {
        /** @var User|null $user */
        $user = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);

        if(is_null($user)){
            return false;
        }

        $token = Uuid::v4();

        $user->setPasswordToken($token);
        $this->manager->persist($user);
        $this->manager->flush();

        $this->mailerService->sendPasswordToken($user->getEmail(), $token);

        return $token;
    }
}