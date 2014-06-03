<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\ORM\EntityManager;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EntityManagerSpy extends EntityManager
{
    public function __construct()
    {
    }

    public function getConnection()
    {
        return new ConnectionMock();
    }
}
