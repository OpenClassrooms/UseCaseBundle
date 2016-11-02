<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Security\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\Impl\AuthorizationCheckerSecurityAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\NotGrantedAuthorizationCheckerStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\AuthorizationCheckerSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class AuthorizationCheckerSecurityAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function IsGranted_DonTThrowException()
    {
        $security = new AuthorizationCheckerSecurityAdapter(new AuthorizationCheckerSpy());
        $security->checkAccess(array());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function IsNotGranted_ThrowAccessDeniedException()
    {
        $security = new AuthorizationCheckerSecurityAdapter(new NotGrantedAuthorizationCheckerStub());
        $security->checkAccess(array());
    }
}
