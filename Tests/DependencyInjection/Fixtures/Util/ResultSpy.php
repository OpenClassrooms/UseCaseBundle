<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Driver\Result;

class ResultSpy implements Result
{

    /**
     * @inheritDoc
     */
    public function fetchNumeric()
    {
        // TODO: Implement fetchNumeric() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchAssociative()
    {
        // TODO: Implement fetchAssociative() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchOne()
    {
        // TODO: Implement fetchOne() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchAllNumeric(): array
    {
        // TODO: Implement fetchAllNumeric() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchAllAssociative(): array
    {
        // TODO: Implement fetchAllAssociative() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchFirstColumn(): array
    {
        // TODO: Implement fetchFirstColumn() method.
    }

    /**
     * @inheritDoc
     */
    public function rowCount(): int
    {
        // TODO: Implement rowCount() method.
    }

    /**
     * @inheritDoc
     */
    public function columnCount(): int
    {
        // TODO: Implement columnCount() method.
    }

    /**
     * @inheritDoc
     */
    public function free(): void
    {
        // TODO: Implement free() method.
    }
}