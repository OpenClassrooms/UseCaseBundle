<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\DoctrineDBALConnectionTransactionAdapter;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
    public function createEntityManagerTransaction(EntityManagerInterface $em);
}
