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
     * @var EntityManagerInterface::
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        if (!$this->isTransactionActive()) {
            $this->em->beginTransaction();
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->em->getConnection()->isTransactionActive();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        $this->em->flush();
        $this->em->commit();

        return true;
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        $this->em->rollback();

        return true;
    }
}
