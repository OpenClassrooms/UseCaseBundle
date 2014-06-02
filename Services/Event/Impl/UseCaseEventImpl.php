<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\UseCaseEvent;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseEventImpl extends Event implements UseCaseEvent
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var UseCaseRequest
     */
    private $useCaseRequest;

    /**
     * @var UseCaseResponse
     */
    private $useCaseResponse;

    /**
     * @var \Exception
     */
    private $useCaseException;

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest()
    {
        return $this->useCaseRequest;
    }

    public function setUseCaseRequest(UseCaseRequest $useCaseRequest)
    {
        $this->useCaseRequest = $useCaseRequest;
    }

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse()
    {
        return $this->useCaseResponse;
    }

    public function setUseCaseResponse(UseCaseResponse $useCaseResponse)
    {
        $this->useCaseResponse = $useCaseResponse;
    }

    /**
     * @return \Exception
     */
    public function getUseCaseException()
    {
        return $this->useCaseException;
    }

    public function setUseCaseException(\Exception $useCaseException)
    {
        $this->useCaseException = $useCaseException;
    }
}
