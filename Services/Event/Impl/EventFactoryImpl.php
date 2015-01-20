<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\UseCaseEvent;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\UseCaseEventBuilder;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactoryImpl implements EventFactory
{
    /**
     * @var UseCaseEventBuilder
     */
    private $useCaseEventBuilder;

    /**
     * @return UseCaseEvent
     * @throws InvalidEventNameException
     */
    public function make(
        $eventName,
        UseCaseRequest $useCaseRequest = null,
        UseCaseResponse $useCaseResponse = null,
        \Exception $exception = null
    ) {
        return $this->useCaseEventBuilder
            ->create()
            ->named($eventName)
            ->withUseCaseRequest($useCaseRequest)
            ->withUseCaseResponse($useCaseResponse)
            ->withUseCaseException($exception)
            ->build();
    }

    public function setUseCaseEventBuilder(UseCaseEventBuilder $useCaseEventBuilder)
    {
        $this->useCaseEventBuilder = $useCaseEventBuilder;
    }
}
