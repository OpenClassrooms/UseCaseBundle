<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Transaction\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\ConnectionMock;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
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
        $this->assertTrue(ConnectionMock::$transactionBegin);
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
    }

    protected function setUp()
    {
        $this->entityManager = new EntityManagerSpy();
        $this->transaction = new EntityManagerTransactionAdapter($this->entityManager);
    }
}
