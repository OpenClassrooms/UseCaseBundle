<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->extension('open_classrooms_use_case', [
        'security' => 'openclassrooms.tests.util.configuration_authorization_checker_stub',
    ]);
};
