<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\ORM\EntityManager;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EntityManagerSpy extends EntityManager
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
}
