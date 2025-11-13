<?php

namespace App\Controller\Auth;

use App\DTO\UserForgetPasswordDto;
use App\Service\AuthService;
use App\Service\UtilitaireService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Handle forget password requests by sending a reset token.
 */
#[Route(path: '/api/v1/auth', name: 'app_v1_auth_')]
final class ForgetPasswordController extends AbstractController
{
    public function __construct(
        private readonly UtilitaireService $utilitaireService,
        private readonly AuthService       $authService, private readonly LoggerInterface $logger
    ) {}

    #[Route(path: '/forget-password', name: 'forget_password', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent());

            /** @var UserForgetPasswordDto $dto */
            $dto = $this->utilitaireService->mapAndValidateRequestDto($data, new UserForgetPasswordDto());

            $this->authService->forgetPassword($dto);

            $this->logger->log(1,sprintf("send email for reset password at %s", $dto->email));

            return $this->json(['success'=>true, 'message' => 'Password reset email sent.'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->json(['message' => $e->getMessage(), 'success'=>false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
