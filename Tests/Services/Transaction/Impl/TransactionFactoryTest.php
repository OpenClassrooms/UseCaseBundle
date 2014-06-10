<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Transaction\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\TransactionFactoryImpl;
use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util\ConnectionMock;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function CreateDoctrineDBALConnectionTransaction_ReturnDoctrineDBALConnectionTransactionAdapter()
    {
        $factory = new TransactionFactoryImpl();
        $transaction = $factory->createDoctrineDBALConnectionTransaction(new ConnectionMock());
        $this->assertInstanceOf('OpenClassrooms\UseCase\Application\Services\Transaction\Transaction', $transaction);
    }
}
