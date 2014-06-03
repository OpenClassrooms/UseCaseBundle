<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Connection;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ConnectionMock extends Connection
{
    /**
     * @var bool
     */
    public static $transactionBegin = false;

    /**
     * @var bool
     */
    public static $committed = false;

    /**
     * @var bool
     */
    public static $rollBacked = false;

    /**
     * @var int
     */
    private static $called = 0;

    public function __construct()
    {
        self::$transactionBegin = false;
        self::$committed = false;
        self::$rollBacked = false;
    }

    public function getConnection()
    {
        return new ConnectionMock();
    }

    public function beginTransaction()
    {
        self::$transactionBegin = true;
    }

    public function commit()
    {
        self::$committed = true;
    }

    public function rollback()
    {
        self::$rollBacked = true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return 0 !== self::$called;
    }
}
