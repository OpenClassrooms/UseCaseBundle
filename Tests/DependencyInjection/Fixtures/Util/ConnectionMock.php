<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ConnectionMock
{
    /**
     * @var int
     */
    private static $called = 0;

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return 0 !== self::$called;
    }
}
