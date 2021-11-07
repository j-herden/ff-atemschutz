<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserChangePassword;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, LoggerInterface $authLogger)
    {
        // 1) build the form
        $user = new User();
        // workaround for a default value that is needed for easy admin
        $user->setOldPlainPassword('');
        $form = $this->createForm(UserChangePassword::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $checkPass = $passwordHasher->isPasswordValid($this->getUser(), $user->getOldPlainPassword() );
            if($checkPass === true)
            {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordHasher->hashPassword($this->getUser(), $user->getPlainPassword());
                $this->getUser()->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($this->getUser());
                $entityManager->flush();

                $this->addFlash('success', "Das Passwort wurde geändert");
                $authLogger->info( 'Password changed ' . $this->getUser()->getUserIdentifier() );

                return $this->redirect($request->getUri());
            }
            else {
                $this->addFlash('error', "Das aktuelle Passwort ist nicht korrekt");
            }
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form'            => $form->createView(),
        ]);
    }
}
