<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction;

use Doctrine\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\DoctrineDBALConnectionTransactionAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface TransactionFactory
{
    /**
     * @return DoctrineDBALConnectionTransactionAdapter
     */
    public function createDoctrineDBALConnectionTransaction(Connection $connection);

    /**
     * @return EntityManagerTransactionAdapter
     */
    public function createEntityManagerTransaction(ObjectManager $em);
}
