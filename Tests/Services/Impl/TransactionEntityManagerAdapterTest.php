<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\Services\Impl;

use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Transaction\Impl\TransactionEntityManagerAdapter;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util\EntityManagerSpy;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionEntityManagerAdapterTest extends \PHPUnit_Framework_TestCase
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
        $this->assertTrue($this->entityManager->transactionBegin);
    }

    /**
     * @test
     */
    public function AlreadyActiveTransaction_BeginTransaction_ReturnTransaction()
    {
        $this->transaction->beginTransaction();
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue($this->entityManager->transactionBegin);
    }

    /**
     * @test
     */
    public function Commit()
    {
        $this->transaction->beginTransaction();
        $committed = $this->transaction->commit();
        $this->assertTrue($committed);
        $this->assertTrue($this->entityManager->committed);
    }
    /**
     * @test
     */
    public function RollBack()
    {
        $this->transaction->beginTransaction();
        $rollBacked = $this->transaction->rollBack();
        $this->assertTrue($rollBacked);
        $this->assertTrue($this->entityManager->rollBacked);
    }

    protected function setUp()
    {
        $this->entityManager = new EntityManagerSpy();
        $this->transaction = new TransactionEntityManagerAdapter($this->entityManager);
    }
}
