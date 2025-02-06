<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\ParameterType;

class StatementSpy extends Statement
{
    public function __construct()
    {

    }

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
