<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\RefreshToken;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TokenService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function createJwtToken(UserInterface $user): string
    {
        return $this->jwtManager->create($user);
    }

    /**
     * @throws Exception
     */
    public function createRefreshToken(User $user): string
    {
        $refreshToken = bin2hex(random_bytes(64));
        $hashedToken = hash('sha256', $refreshToken);

        $existingToken = $this->entityManager->getRepository(RefreshToken::class)->findOneBy(['user' => $user]);

        if ($existingToken) {
            $existingToken->setToken($hashedToken);
            $this->entityManager->flush();
        } else {
            $refreshTokenEntity = new RefreshToken();
            $refreshTokenEntity->setUser($user);
            $refreshTokenEntity->setToken($hashedToken);

            $this->entityManager->persist($refreshTokenEntity);
            $this->entityManager->flush();
        }

        return $refreshToken;
    }

    public function isValidRefreshToken(string $token): bool
    {
        $hashedToken = hash('sha256', $token);
        $refreshToken = $this->entityManager->getRepository(RefreshToken::class)->findOneBy(['token' => $hashedToken]);

        if (!$refreshToken) {
            return false;
        }

        return true;
    }

    public function getUserFromRefreshToken(string $token): ?User
    {
        $hashedToken = hash('sha256', $token);
        $refreshToken = $this->entityManager->getRepository(RefreshToken::class)->findOneBy(['token' => $hashedToken]);

        return $refreshToken ? $refreshToken->getUser() : null;
    }
}