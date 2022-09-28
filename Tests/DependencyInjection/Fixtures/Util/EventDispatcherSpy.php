<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventDispatcherSpy extends EventDispatcher
{
    /**
     * @var string
     */
    public static $eventName;

    /**
     * @var bool
     */
    public static $sent = false;

    public function __construct()
    {
        self::$eventName = null;
        self::$sent = false;
    }

    public function dispatch(object $event, string $eventName = null): object
    {
        self::$eventName = $eventName;
        self::$sent = true;

        parent::dispatch($event, $eventName);
    }
}
