<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route(path: '/reset-password', name: 'reset-password')]

 class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $managerRegistry;
    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, ManagerRegistry $doctrine)
    {
        $this->managerRegistry     = $doctrine;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * Display & process form to request a password reset.
     */

    #[Route(path: '', name: 'app_forgot_password_request')]

    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer,
                $request
            );
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     */

    #[Route(path: '/check-email', name: 'app_check_email')]

    public function checkEmail(ResetPasswordHelperInterface $helper): Response
    {
        $resetToken = $this->getTokenObjectFromSession();
        if (null === $resetToken) 
        {
            // make a fake token so we don't expose if an email was really found
            $resetToken = $helper->generateFakeResetToken();
        }

        return $this->render('reset_password/check_email.html.twig', [
            'tokenLifetime' => $this->resetPasswordHelper->getTokenLifetime(),
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */

    #[Route(path: '/reset/{token}', name: 'app_reset_password')]

    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('reset-passwordapp_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                'Es gab ein Problem beim Prüfen der Rücksetz-Anforderung - %s',
                $e->getReason()
            ));

            return $this->redirectToRoute('reset-passwordapp_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->managerRegistry->getManager()->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer, Request $request): RedirectResponse
    {
        $user = $this->managerRegistry->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (! $user) {
            return $this->redirectToRoute('reset-passwordapp_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } 
        catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'reset-passwordapp_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem handling your password reset request - %s',
                $e->getReason()
            ));
            return $this->redirectToRoute('reset-passwordapp_forgot_password_request');

            // return $this->redirectToRoute('reset-passwordapp_check_email');
        }

        $email = ( new TemplatedEmail() )
            ->from( new Address('jens@jherden.de', 'Jens Herden') )
            ->to( $user->getEmail() )
            ->addBcc( 'jens@jherden.de' )
            ->subject( 'Passwort auf ' . $request->getHost() . ' zurücksetzen' )
            ->htmlTemplate( 'reset_password/email.html.twig' )
            ->context([
                'resetToken'    => $resetToken,
                'tokenLifetime' => $this->resetPasswordHelper->getTokenLifetime(),
                'username'      => $user->getName(),
                'loginemail'    => $user->getEmail(),
            ])
        ;

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('reset-passwordapp_check_email');
    }
}
