<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{

    public function __construct(private UserService $userService){}

    #[Route('/api/users/password-token', name: 'user_password_token' ,methods: ['POST'])]
    public function generateToken(Request $request): JsonResponse
    {
        $email = json_decode((string)$request->getContent(), true)['email'] ?? null;

        if(is_null($email)){
            return $this->json([], 400);
        }

        if(!$token = $this->userService->generateToken($email)){
            return $this->json([], 400);
        }

        return $this->json(['token' => $token]);
    }

    #[Route('/api/users/password-refresh', name: 'user_password_refresh' ,methods: ['POST'] )]
    public function refreshPassword(Request $request): JsonResponse
    {
        $content = json_decode((string)$request->getContent(), true);

        $token = $content['token'] ?? null;
        $password = $content['password'] ?? null;

        if(is_null($token) || is_null($password)){
            return $this->json(['message' => 'Token ou password n\'est pas présent.'], 400);
        }

        if(!$this->userService->resetPassword($token, $password)){
            return $this->json(['message' => 'L\'utilisateur n\'a pas pu être retrouvé.'], 400);
        }

        return $this->json(['message' => 'Le mot de passe est modifié.']);
    }
}
