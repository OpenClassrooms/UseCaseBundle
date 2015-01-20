<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Security\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\SecurityFactory;
use OpenClassrooms\UseCase\Application\Services\Security\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityFactoryImpl implements SecurityFactory
{
    /**
     * @return Security
     */
    public function createSecurityContextSecurity(SecurityContextInterface $securityContext)
    {
        return new SecurityContextSecurityAdapter($securityContext);
    }
}
