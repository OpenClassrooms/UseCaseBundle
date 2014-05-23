<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Services\Transaction\Impl;

use Doctrine\ORM\EntityManager;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionEntityManagerAdapter implements Transaction
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        if (!$this->isTransactionActive()) {
            $this->entityManager->beginTransaction();
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->entityManager->getConnection()->isTransactionActive();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        $this->entityManager->commit();

        return true;
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        $this->entityManager->rollback();

        return true;
    }
}
