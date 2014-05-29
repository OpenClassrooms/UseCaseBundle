<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl;

use Doctrine\ORM\EntityManager;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\TransactionFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionFactoryImpl implements TransactionFactory
{
    /**
     * @return EntityManagerTransactionAdapter
     */
    public function createEntityManagerTransaction(EntityManager $entityManager)
    {
        return new EntityManagerTransactionAdapter($entityManager);
    }
}
