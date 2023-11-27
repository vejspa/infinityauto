<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TokenService;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TokenService $tokenService
    ) {
    }

    /**
     * @throws Exception
     */
    #[Route('/api/login', name: 'api_login')]

    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->getUserByUsernameAndPassword($username, $password);

        if (!$user) {
            return $this->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $jwtToken = $this->tokenService->createJwtToken($user);
        $refreshToken = $this->tokenService->createRefreshToken($user);

        return $this->json([
            'token' => $jwtToken,
            'refresh_token' => $refreshToken,
        ]);
    }

    private function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return null;
        }

        // Verify the password
        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        return $user;
    }

}
