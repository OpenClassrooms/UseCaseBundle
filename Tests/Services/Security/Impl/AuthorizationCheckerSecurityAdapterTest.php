<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Security\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\Impl\AuthorizationCheckerSecurityAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\AuthorizationCheckerSpy;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\NotGrantedAuthorizationCheckerStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class AuthorizationCheckerSecurityAdapterTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function IsGranted_DonTThrowException()
    {
        $security = new AuthorizationCheckerSecurityAdapter(new AuthorizationCheckerSpy());
        $security->checkAccess(['ROLE_USER']);
    }

    /**
     * @test
     */
    public function IsNotGranted_ThrowAccessDeniedException()
    {
        $this->expectException(AccessDeniedException::class);

        $security = new AuthorizationCheckerSecurityAdapter(new NotGrantedAuthorizationCheckerStub());
        $security->checkAccess(['ROLE_USER']);
    }
}
