<?php

namespace OpenClassrooms\Bundle\CleanArchitectureBundle;

use OpenClassrooms\Bundle\CleanArchitectureBundle\DependencyInjection\Compiler\UseCaseProxyPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OpenClassroomsCleanArchitectureBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new UseCaseProxyPass());
    }
}
