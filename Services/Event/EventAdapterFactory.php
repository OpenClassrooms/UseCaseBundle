<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface EventAdapterFactory
{
    /**
     * @return EventSender
     */
    public function createEventDispatcherEvent(EventDispatcherInterface $eventDispatcher);
}
