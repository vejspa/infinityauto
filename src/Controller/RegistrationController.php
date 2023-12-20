<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($data); // Use submit for JSON request rather than handleRequest

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password and set it to the user
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $data['plainPassword'] // Get plainPassword from the decoded JSON
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'message' => 'User successfully registered',
                'userId' => $user->getId()
            ], Response::HTTP_CREATED);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $this->json([
            'errors' => $errors
        ], Response::HTTP_BAD_REQUEST);
    }
}
