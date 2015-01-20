<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Doctrine\Common\Cache\ArrayCache;
use OpenClassrooms\Cache\Cache\CacheImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheSpy extends CacheImpl
{
    public static $saved = false;

    public function __construct()
    {
        $this->cache = new ArrayCache();
    }

    public function save($id, $data, $lifeTime = null)
    {
        self::$saved = true;

        return parent::save($id, $data, $lifeTime);
    }
}
