<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction;

use Doctrine\ORM\EntityManager;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl\EntityManagerTransactionAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface TransactionFactory
{
    /**
     * @return EntityManagerTransactionAdapter
     */
    public function createEntityManagerTransaction(EntityManager $entityManager);
}
