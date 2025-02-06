<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Result;

class ResultSpy extends Result
{
    public function __construct()
    {

    }

    public function fetchNumeric(): false|array
    {
    }

    public function fetchAssociative(): false|array
    {
    }

    public function fetchOne(): mixed
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
