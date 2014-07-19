<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Proxy;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface UseCaseProxyFactory
{
    public function create(UseCase $useCase, $tagParameters);
}
