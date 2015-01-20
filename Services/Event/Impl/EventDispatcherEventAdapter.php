<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventDispatcherEventAdapter implements EventSender
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function send($eventName, $event)
    {
        /** @var Event $event */
        $this->eventDispatcher->dispatch($eventName, $event);
    }
}
