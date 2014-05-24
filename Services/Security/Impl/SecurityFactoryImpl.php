<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Security\Impl;

use OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Security\SecurityFactory;
use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
