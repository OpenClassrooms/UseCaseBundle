<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\CleanArchitecture\Application\Services\Event\EventFactory;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

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
