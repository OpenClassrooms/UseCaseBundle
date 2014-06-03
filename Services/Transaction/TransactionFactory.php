<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction;

use Doctrine\DBAL\Connection;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\DoctrineDBALConnectionTransactionAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface TransactionFactory
{
    /**
     * @return DoctrineDBALConnectionTransactionAdapter
     */
    public function createDoctrineDBALConnectionTransaction(Connection $connection);
}
