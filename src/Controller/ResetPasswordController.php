<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResetPasswordController extends AbstractController
{
    public function __invoke(Request $request, UserService $userService): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        if(!$userService->resetPassword($this->getUser(), $content['password'])){
            return $this->json([], 400);
        }

        return $this->json(
            ['password' => $content['password']]
        );
    }
}
