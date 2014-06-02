<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface EventAdapterFactory
{
    /**
     * @return EventSender
     */
    public function createEventDispatcherEvent(EventDispatcherInterface $eventDispatcher);
}
