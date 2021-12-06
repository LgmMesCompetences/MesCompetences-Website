<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

use App\Entity\Posseder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PossederUserSetterListener implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->action($args);
    }

    private function action(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Posseder) {
            return;
        }

        $entity->setUser(
            $this->tokenStorage->getToken()->getUser()
        );
    }
}