<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Driver\Result;

class ResultSpy implements Result
{
    public function fetchNumeric()
    {
    }

    public function fetchAssociative()
    {
    }

    public function fetchOne()
    {
    }

    public function fetchAllNumeric(): array
    {
    }

    public function fetchAllAssociative(): array
    {
    }

    public function fetchFirstColumn(): array
    {
    }

    public function rowCount(): int
    {
    }

    public function columnCount(): int
    {
    }

    public function free(): void
    {
    }
}
