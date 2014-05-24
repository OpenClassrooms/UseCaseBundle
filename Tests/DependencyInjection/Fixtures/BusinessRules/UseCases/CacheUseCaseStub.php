<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Cache;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheUseCaseStub extends UseCaseStub
{
    /**
     * @cache
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }

}
