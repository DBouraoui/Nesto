<?php

namespace App\Controller\Auth;

use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/v1', name: 'app_auth_v1_')]
class UpdateInformation
{
    public function __construct(){}
    #[Route('/update', name: 'update', methods: ['PUT'])]
    public function __invoke(){}

}
