<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

readonly class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private int $tokenTtl = 3600 // 1 heure par défaut
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $user = $token->getUser();

        // Génère le JWT
        $jwt = $this->jwtManager->create($user);

        // Crée le cookie sécurisé
        $cookie = Cookie::create('BEARER')
            ->withValue($jwt)
            ->withExpires(time() + $this->tokenTtl)
            ->withPath('/')
            ->withSecure(true) // HTTPS uniquement
            ->withHttpOnly(true) // Pas accessible via JavaScript
            ->withSameSite('lax') // Protection CSRF (utilise 'none' si front sur domaine différent)
        ;

        $response = new JsonResponse([
            'success' => true,
            'message' => 'Connexion réussie',
            'user' => [
                'email' => $user->getEmail(),
            ]
        ]);

        $response->headers->setCookie($cookie);

        return $response;
    }
}
