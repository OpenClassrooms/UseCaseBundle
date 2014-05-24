<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Transaction;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionUseCaseStub extends UseCaseStub
{
    /**
     * @transaction
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
