<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Security;

use OpenClassrooms\UseCase\Application\Services\Security\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface SecurityFactory
{
    /**
     * @return Security
     */
    public function createSecurityContextSecurity(SecurityContextInterface $securityContext);
}
