<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseResponseStub;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseStub implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return new UseCaseResponseStub();
    }
}
