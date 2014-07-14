<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\EventUseCaseStub;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactorySpy implements EventFactory
{
    /**
     * @return mixed
     * @throws InvalidEventNameException
     */
    public function make(
        $eventName,
        UseCaseRequest $useCaseRequest = null,
        UseCaseResponse $useCaseResponse = null,
        \Exception $exception = null
    )
    {
        if (EventUseCaseStub::EVENT_NAME === $eventName) {
            return new Event();
        } else {
            throw new InvalidEventNameException($eventName);
        }

    }

}
