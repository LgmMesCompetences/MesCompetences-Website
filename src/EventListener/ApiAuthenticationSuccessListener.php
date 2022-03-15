<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiAuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        /** @var \App\Entity\User */
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['user']['id'] = $user->getId();
        $data['user']['email'] = $user->getEmail();

        $event->setData($data);
    }
}