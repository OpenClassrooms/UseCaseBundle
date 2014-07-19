<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

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
     * @var Connection
     */
    protected $conn;

    public function __construct()
    {
        $this->conn = new ConnectionMock();
        self::$flushed = false;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function flush()
    {
        self::$flushed = true;
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }
}
