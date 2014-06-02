<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventSenderSpy implements EventSender
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
        self::$sent = false;
    }

    public function send($eventName, $event)
    {
        self::$eventName = $eventName;
        self::$sent = true;
    }

}
