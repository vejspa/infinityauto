<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\TokenService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefreshTokenController extends AbstractController
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @throws Exception
     */
    #[Route(
        '/api/refresh-token',
        name: 'api_refresh_token',
        methods: ['POST']
    )]
    public function refreshToken(Request $request): JsonResponse
    {
        $refreshToken = $request->request->get('refresh_token');

        if (!$refreshToken || !$this->tokenService->isValidRefreshToken($refreshToken)) {
            return $this->json(['message' => 'Invalid refresh token'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->tokenService->getUserFromRefreshToken($refreshToken);

        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_UNAUTHORIZED);
        }

        $newJwtToken = $this->tokenService->createJwtToken($user);
        $newRefreshToken = $this->tokenService->createRefreshToken($user);

        return $this->json([
            'token' => $newJwtToken,
            'refresh_token' => $newRefreshToken,
        ]);
    }
}
