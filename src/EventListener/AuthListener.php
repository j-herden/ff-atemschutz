<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
// use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\DeauthenticatedEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class AuthListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLogout( LogoutEvent $event )
    {
        $this->logger->warning( 'Logout ' . $event->getToken()->getUsername() );
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->logger->warning( 'Login ' . $event->getAuthenticationToken()->getUsername() );
    }

}
