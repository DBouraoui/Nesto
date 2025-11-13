<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/v1/user', name: 'app_user_v1_')]
class me extends AbstractController
{

    #[Route('/me', name: 'update', methods: ['GET'])]
    public function __invoke(#[CurrentUser]User $user){
        try {

            return $this->json($user->getUserIdentifier(), 200);
        } catch (\Throwable $th) {
            return $this->json(['error' => $th->getMessage()], 400);
        }
    }

}
