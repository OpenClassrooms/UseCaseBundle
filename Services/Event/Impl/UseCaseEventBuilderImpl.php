<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\UseCaseEventBuilder;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseEventBuilderImpl extends UseCaseEventBuilder
{
    /**
     * @var UseCaseEventImpl
     */
    protected $event;

    /**
     * @return UseCaseEventBuilder
     */
    public function create()
    {
        $this->event = new UseCaseEventImpl();

        return $this;
    }

    /**
     * @return UseCaseEventBuilder
     */
    public function named($name)
    {
        $this->event->setName($name);

        return $this;
    }

    /**
     * @return UseCaseEventBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest = null)
    {
        if (null !== $useCaseRequest) {
            $this->event->setUseCaseRequest($useCaseRequest);
        }

        return $this;
    }

    /**
     * @return UseCaseEventBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse = null)
    {
        if (null !== $useCaseResponse) {
            $this->event->setUseCaseResponse($useCaseResponse);
        }

        return $this;
    }

    /**
     * @return UseCaseEventBuilder
     */
    public function withUseCaseException(\Exception $exception = null)
    {
        if (null !== $exception) {
            $this->event->setUseCaseException($exception);
        }

        return $this;
    }
}
