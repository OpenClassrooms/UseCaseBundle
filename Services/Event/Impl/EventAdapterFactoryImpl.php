<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\EventAdapterFactory;
use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventAdapterFactoryImpl implements EventAdapterFactory
{
    /**
     * @return EventSender
     */
    public function createEventDispatcherEvent(EventDispatcherInterface $eventDispatcher)
    {
        return new EventDispatcherEventAdapter($eventDispatcher);
    }
}
