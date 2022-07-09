<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class AuthListener
{
    private $logger;

    public function __construct(LoggerInterface $authLogger)
    {
        $this->logger = $authLogger;
    }

    public function onLogout( LogoutEvent $event )
    {
        if ( $event->getToken() ) 
        {
            $this->logger->info( 'Logout ' . $event->getToken()->getUserIdentifier() );
        }
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->logger->info( 'Login ' . $event->getAuthenticationToken()->getUserIdentifier() );
    }

}
