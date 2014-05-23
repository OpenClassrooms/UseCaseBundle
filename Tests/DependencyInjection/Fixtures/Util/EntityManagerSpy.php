<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\ORM\EntityManager;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EntityManagerSpy extends EntityManager
{
    /**
     * @var bool
     */
    public $transactionBegin = false;

    /**
     * @var bool
     */
    public $committed = false;

    /**
     * @var bool
     */
    public $rollBacked = false;

    public function __construct()
    {
    }

    public function getConnection()
    {
        return new ConnectionMock();
    }

    public function beginTransaction()
    {
        $this->transactionBegin = true;
    }

    public function commit()
    {
        $this->committed = true;
    }

    public function rollback()
    {
        $this->rollBacked = true;
    }
}
