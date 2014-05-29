<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\Util;

use OpenClassrooms\UseCase\Application\Services\Event\Event;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventSpy implements Event
{
    /**
     * @var bool
     */
    public static $sent = false;

    public function __construct()
    {
        self::$sent = false;
    }

    public function send($event)
    {
        self::$sent = true;
    }

}
