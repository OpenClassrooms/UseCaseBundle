<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\CacheItem;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheSpy extends ArrayAdapter
{
    /**
     * @var array<string, true>
     */
    public static array $saved = [];

    /**
     * @var array<string, true>
     */
    public static array $getted = [];

    public function save(CacheItemInterface $item): bool
    {
        self::$saved[$item->getKey()] = (new \ReflectionProperty($item, 'expiry'))->getValue($item);

        return parent::save($item);
    }

    public function getItem(mixed $key): CacheItem
    {
        $item = parent::getItem($key);

        self::$getted[$item->getKey()] = $item->isHit();

        return $item;
    }
}
