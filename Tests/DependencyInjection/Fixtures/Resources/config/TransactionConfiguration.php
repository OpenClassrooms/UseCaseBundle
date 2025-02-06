<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('open_classrooms_use_case', [
    'transaction' => 'openclassrooms.tests.util.configuration_entity_manager_stub',
    ]);
};
