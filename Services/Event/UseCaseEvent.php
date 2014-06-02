<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Event;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface UseCaseEvent
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest();

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse();

    /**
     * @return \Exception
     */
    public function getUseCaseException();
}
