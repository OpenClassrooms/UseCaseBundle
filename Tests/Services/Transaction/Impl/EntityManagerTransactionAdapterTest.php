<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\Services\Transaction\Impl;

use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EntityManagerTransactionAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerSpy
     */
    private $entityManager;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @test
     */
    public function BeginTransaction_ReturnTransaction()
    {
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue(EntityManagerSpy::$transactionBegin);
    }

    /**
     * @test
     */
    public function AlreadyActiveTransaction_BeginTransaction_ReturnTransaction()
    {
        $this->transaction->beginTransaction();
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue(EntityManagerSpy::$transactionBegin);
    }

    /**
     * @test
     */
    public function Commit()
    {
        $this->transaction->beginTransaction();
        $committed = $this->transaction->commit();
        $this->assertTrue($committed);
        $this->assertTrue(EntityManagerSpy::$committed);
    }
    /**
     * @test
     */
    public function RollBack()
    {
        $this->transaction->beginTransaction();
        $rollBacked = $this->transaction->rollBack();
        $this->assertTrue($rollBacked);
        $this->assertTrue(EntityManagerSpy::$rollBacked);
    }

    protected function setUp()
    {
        $this->entityManager = new EntityManagerSpy();
        $this->transaction = new EntityManagerTransactionAdapter($this->entityManager);
    }
}
