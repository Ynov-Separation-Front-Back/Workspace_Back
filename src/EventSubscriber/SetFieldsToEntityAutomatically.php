<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Group;
use App\Entity\GroupRequest;
use App\Entity\Message;
use App\Entity\Thread;

class SetFieldsToEntityAutomatically implements EventSubscriberInterface {
    public function __construct(private readonly TokenStorageInterface $tokenStorage) {
        
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => ['setFieldToEntity', EventPriorities::PRE_WRITE],
        ];
    }

    public function setFieldToEntity(ViewEvent $event) {
        $entity = $event->getControllerResult();
        $methode = $event->getRequest()->getMethod();
        if (get_class($entity) === User::class && in_array($methode, [Request::METHOD_POST])) {
            return;
        }
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user !== null && get_class($entity) === Group::class && in_array($methode, [Request::METHOD_POST])) {
            $entity->setOwner($user);
        }

        if ($user !== null && get_class($entity) === Thread::class && in_array($methode, [Request::METHOD_POST])) {
            $entity->setOwner($user);
        }

        if ($user !== null && get_class($entity) === Message::class && in_array($methode, [Request::METHOD_POST])) {
            $entity->setOwner($user);
        }

        if ($user !== null && get_class($entity) === Message::class && in_array($methode, [Request::METHOD_PATCH])) {
            $entity->setUpdatedAt(new \DateTime());
        }

        if ($user !== null && get_class($entity) === GroupRequest::class && in_array($methode, [Request::METHOD_POST])) {
            $entity->setUser($user);
        }
    }
}