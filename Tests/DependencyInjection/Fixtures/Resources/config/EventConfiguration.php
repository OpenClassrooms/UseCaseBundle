<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('open_classrooms_use_case', [
        'event_sender' => 'openclassrooms.tests.util.configuration_event_dispatcher_stub',
        'event_factory' => 'openclassrooms.tests.util.configuration_event_factory_stub',
    ]);
};
