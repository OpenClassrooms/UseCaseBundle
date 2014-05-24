<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Security\Impl;

use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityContextSecurityAdapter implements Security
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @throws \Exception
     */
    public function checkAccess($attributes, $object = null)
    {
        if (!$this->securityContext->isGranted($attributes, $object)) {
            throw new AccessDeniedException();
        }
    }

}
