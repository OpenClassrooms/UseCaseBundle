<?php

namespace OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Yaml;

use OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\AbstractDependencyInjectionTestCase;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionOpenClassroomsUseCaseExtensionTest extends AbstractDependencyInjectionTestCase
{
    /**
     * @test
     */
    public function WithTransactionConfigurationWithoutTransaction_TransactionUseCase_ThrowException()
    {
        $this->expectException(TransactionIsNotDefinedException::class);

        $this->configLoader->load('TransactionConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');
    }

    /**
     * @test
     */
    public function WithDefaultConfigurationWithoutTransaction_TransactionUseCase_ThrowException()
    {
        $this->expectException(TransactionIsNotDefinedException::class);
        $this->expectExceptionMessage("Transaction should be defined for use case: OpenClassrooms\Bundle\UseCaseBundle\Tests\DependencyInjection\Fixtures\BusinessRules\UseCases\TransactionUseCaseStub. Default entity manager: 'doctrine.orm.entity_manager' is not defined.");

        $this->configLoader->load('DefaultConfiguration.php');
        $this->container->compile();

        $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');
    }

    /**
     * @test
     */
    public function WithTransactionConfiguration_TransactionUseCase_ReturnUseCaseProxy()
    {
        $this->configLoader->load('TransactionConfiguration.php');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');

        $this->assertTransactionUseCaseProxy($useCaseProxy);
    }

    /**
     * @test
     */
    public function WithDefaultConfiguration_ReturnUseCaseProxy()
    {
        $this->configLoader->load('DefaultConfiguration.php');
        $this->serviceLoader->load('default_services.xml');
        $this->container->compile();

        /** @var UseCaseProxy $useCaseProxy */
        $useCaseProxy = $this->container->get('openclassrooms.tests.use_cases.configuration_transaction_use_case_stub');

        $this->assertTransactionUseCaseProxy($useCaseProxy);
    }

    protected function setUp(): void
    {
        $this->initContainer();
        $this->serviceLoader->load('transaction_configuration_services.xml');
    }
}
