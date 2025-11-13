<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/v1', name: 'app_auth_v1_')]
class UpdateInformation extends AbstractController
{
    public function __construct(){}
    #[Route('/user', name: 'update', methods: ['PUT'])]
    public function __invoke(Request $request, #[CurrentUser]User $user){
        try {
            $data = json_decode($request->getContent());
            if (empty($data)) {
                return $this->json(['message'=> 'Request is empty', ]);
            }

            return $this->json($data);


//            return $this->json(['success'=>true, 'message'=>'']);
        } catch (\Throwable $th) {
            return $this->json(['success' => false, 'message'=>$th->getMessage()], 400);
        }
    }

}
