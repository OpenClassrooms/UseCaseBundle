<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Security\Impl;

use OpenClassrooms\UseCase\Application\Services\Security\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class AuthorizationCheckerSecurityAdapter implements Security
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @throws \Exception
     */
    public function checkAccess($attributes, $object = null)
    {
        if (!$this->authorizationChecker->isGranted($attributes, $object)) {
            throw new AccessDeniedException();
        }
    }
}
