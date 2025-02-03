<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;

class StatementSpy extends \Doctrine\DBAL\Statement
{
    public function bindValue($param, $value, $type = ParameterType::STRING): void
    {
    }

    public function bindParam($param, &$variable, $type = ParameterType::STRING, $length = null)
    {
    }

    public function execute($params = null): Result
    {
    }
}
