<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\UseCase\Application\Services\Security\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecuritySpy implements Security
{
    public static $checked = false;

    /**
     * @throws \Exception
     */
    public function checkAccess($attributes, $object = null)
    {
        self::$checked = true;

        return null;
    }

}
