<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Security;

use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface SecurityFactory
{
    /**
     * @return Security
     */
    public function createSecurityContextSecurity(SecurityContextInterface $securityContext);
}
