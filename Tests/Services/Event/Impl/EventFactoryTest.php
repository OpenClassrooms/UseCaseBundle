<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\Services\Event\Impl;

use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl\EventFactoryImpl;
use OpenClassrooms\Bundle\UseCaseBundle\Services\Event\Impl\UseCaseEventBuilderImpl;
use
    OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseRequestStub;
use
    OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\DTO\UseCaseResponseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactoryTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_EXCEPTION_MESSAGE = 'exception message';

    const EXPECTED_EVENT_NAME = 'event_name';

    /**
     * @test
     */
    public function makeWithException_ReturnUseCaseEvent()
    {
        $eventFactory = new EventFactoryImpl();
        $eventFactory->setUseCaseEventBuilder(new UseCaseEventBuilderImpl());
        $event = $eventFactory->make(
            self::EXPECTED_EVENT_NAME,
            new UseCaseRequestStub(),
            new UseCaseResponseStub(),
            new \Exception(self::EXPECTED_EXCEPTION_MESSAGE)
        );
        $this->assertEquals(self::EXPECTED_EVENT_NAME, $event->getName());
        $this->assertEquals(new UseCaseRequestStub(), $event->getUseCaseRequest());
        $this->assertEquals(new UseCaseResponseStub(), $event->getUseCaseResponse());
        $this->assertEquals(new \Exception(self::EXPECTED_EXCEPTION_MESSAGE), $event->getUseCaseException());
    }
}
