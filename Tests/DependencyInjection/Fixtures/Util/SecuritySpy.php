<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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
