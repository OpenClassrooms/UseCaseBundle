<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
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

    public function dispatch($eventName, Event $event = null)
    {
        self::$eventName = $eventName;
        self::$sent = true;

        parent::dispatch($eventName, $event);
    }

}