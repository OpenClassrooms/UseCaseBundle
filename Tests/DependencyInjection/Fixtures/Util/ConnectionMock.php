<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ConnectionMock implements DriverConnection
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

    public function getConnection(): self
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

    /**
     * {@inheritDoc}
     */
    public function prepare($sql): StatementSpy
    {
        return new StatementSpy();
    }

    /**
     * {@inheritDoc}
     */
    public function query(string $sql): ResultSpy
    {
        return new ResultSpy();
    }

    /**
     * {@inheritDoc}
     */
    public function quote($value, $type = ParameterType::STRING)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function exec($sql): int
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function lastInsertId($name = null)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function errorCode()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function errorInfo()
    {
        return null;
    }
}
