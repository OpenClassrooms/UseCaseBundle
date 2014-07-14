<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Security\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Security\Impl\SecurityContextSecurityAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\NotGrantedSecurityContextStub;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\SecurityContextSpy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityContextSecurityAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function IsGranted_DonTThrowException()
    {
        $security = new SecurityContextSecurityAdapter(new SecurityContextSpy());
        $security->checkAccess(array());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function IsNotGranted_ThrowAccessDeniedException()
    {
        $security = new SecurityContextSecurityAdapter(new NotGrantedSecurityContextStub());
        $security->checkAccess(array());
    }

}
