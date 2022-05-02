<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl;

use Doctrine\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\TransactionFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionFactoryImpl implements TransactionFactory
{
    /**
     * @return DoctrineDBALConnectionTransactionAdapter
     */
    public function createDoctrineDBALConnectionTransaction(Connection $connection)
    {
        return new DoctrineDBALConnectionTransactionAdapter($connection);
    }

    /**
     * @return EntityManagerTransactionAdapter
     */
    public function createEntityManagerTransaction(ObjectManager $em)
    {
        return new EntityManagerTransactionAdapter($em);
    }
}
