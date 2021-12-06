<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Serializer\Serializer;

class ApiAuthenticationSuccessListener
{
    private $serializer;

    public function __construct(Serializer $serializer) {
        $this->serializer = $serializer;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['user'] = $this->serializer->normalize($user->getId(), null);

        $event->setData($data);
    }
}