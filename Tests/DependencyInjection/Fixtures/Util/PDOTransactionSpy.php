<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Impl\TransactionPDOAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PDOTransactionSpy extends TransactionPDOAdapter
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
        $this->pdo = new \PDO('sqlite::memory:');
        self::$transactionBegin = false;
        self::$committed = false;
        self::$rollBacked = false;
    }


    public function beginTransaction()
    {
        self::$transactionBegin = true;
        return parent::beginTransaction();
    }

    public function commit()
    {
        self::$committed = true;
        return parent::commit();
    }

    public function rollback()
    {
        self::$rollBacked = true;
        return parent::rollBack();
    }
}
