<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Connection;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
    public static $transactionNumber = 0;

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
        self::$transactionNumber++;
        self::$transactionBegin = true;
    }

    public function commit()
    {
        self::$committed = true;
        ConnectionMock::$transactionNumber--;
    }

    public function rollback()
    {
        self::$rollBacked = true;
        ConnectionMock::$transactionNumber--;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return self::$transactionNumber > 0;
    }
}
