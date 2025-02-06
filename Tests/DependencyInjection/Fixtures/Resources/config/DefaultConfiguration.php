<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Cache\Adapter\ArrayAdapter;

return static function (ContainerConfigurator $container): void {
    $container->extension('open_classrooms_use_case', [

    ]);
};
