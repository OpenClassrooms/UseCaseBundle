<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Transaction\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\ConnectionMock;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EntityManagerTransactionAdapterTest extends TestCase
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
        $this->assertTrue(ConnectionMock::$transactionBegin);
        $this->assertTrue($this->transaction->isTransactionActive());
    }

    /**
     * @test
     */
    public function AlreadyActiveTransaction_BeginTransaction_ReturnTransaction()
    {
        $this->transaction->beginTransaction();
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue(ConnectionMock::$transactionBegin);
        $this->assertTrue($this->transaction->isTransactionActive());
    }

    /**
     * @test
     */
    public function Commit()
    {
        $this->transaction->beginTransaction();
        $committed = $this->transaction->commit();
        $this->assertTrue($committed);
        $this->assertTrue(EntityManagerSpy::$flushed);
        $this->assertTrue(ConnectionMock::$committed);
        $this->assertFalse($this->transaction->isTransactionActive());
    }

    /**
     * @test
     */
    public function RollBack()
    {
        $this->transaction->beginTransaction();
        $rollBacked = $this->transaction->rollBack();
        $this->assertTrue($rollBacked);
        $this->assertTrue(ConnectionMock::$rollBacked);
        $this->assertFalse($this->transaction->isTransactionActive());
    }

    protected function setUp():void
    {
        ConnectionMock::$transactionNumber = 0;
        $this->entityManager = new EntityManagerSpy();
        $this->transaction = new EntityManagerTransactionAdapter($this->entityManager);
    }
}
