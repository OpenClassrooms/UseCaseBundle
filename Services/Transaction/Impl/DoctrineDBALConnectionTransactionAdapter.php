<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Services\Transaction\Impl;

use Doctrine\DBAL\Connection;
use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class DoctrineDBALConnectionTransactionAdapter implements Transaction
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();

        return true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->connection->isTransactionActive();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        $this->connection->commit();

        return true;
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        $this->connection->rollback();

        return true;
    }
}
