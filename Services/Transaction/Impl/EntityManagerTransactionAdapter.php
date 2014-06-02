<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl;

use Doctrine\ORM\EntityManagerInterface;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EntityManagerTransactionAdapter implements Transaction
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
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
