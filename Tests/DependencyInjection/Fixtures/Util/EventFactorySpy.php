<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use
    OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
        return null;
    }

}
