<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EntityManagerSpy extends EntityManager
{
    /**
     * @var bool
     */
    public static $flushed = false;

    /**
     * @var Connection|ConnectionMock
     */
    protected $conn;

    public function __construct()
    {
        $this->conn = new ConnectionMock();
        self::$flushed = false;
    }

    public function getConnection(): Connection
    {
        return $this->conn;
    }

    public function beginTransaction(): void
    {
        $this->conn->beginTransaction();
    }

    public function flush($entity = null): void
    {
        self::$flushed = true;
    }

    public function commit(): void
    {
        $this->conn->commit();
    }

    public function rollback(): void
    {
        $this->conn->rollback();
    }
}
