<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Transaction;

use Doctrine\ORM\EntityManager;
use
    OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Transaction\Impl\TransactionEntityManagerAdapter;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface TransactionFactory
{
    /**
     * @return TransactionEntityManagerAdapter
     */
    public function createEntityManagerTransaction(EntityManager $entityManager);
}
