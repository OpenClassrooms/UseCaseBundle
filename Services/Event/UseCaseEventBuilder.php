<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class UseCaseEventBuilder
{
    /**
     * @var UseCaseEvent
     */
    protected $event;

    /**
     * @return UseCaseEventBuilder
     * @codeCoverageIgnore
     */
    abstract public function create();

    /**
     * @return UseCaseEventBuilder
     * @codeCoverageIgnore
     */
    abstract public function named($name);

    /**
     * @return UseCaseEventBuilder
     * @codeCoverageIgnore
     */
    abstract public function withUseCaseRequest(UseCaseRequest $useCaseRequest = null);

    /**
     * @return UseCaseEventBuilder
     * @codeCoverageIgnore
     */
    abstract public function withUseCaseResponse(UseCaseResponse $useCaseResponse = null);

    /**
     * @return UseCaseEventBuilder
     * @codeCoverageIgnore
     */
    abstract public function withUseCaseException(\Exception $exception = null);

    /**
     * @return UseCaseEvent
     */
    public function build()
    {
        return $this->event;
    }
}
