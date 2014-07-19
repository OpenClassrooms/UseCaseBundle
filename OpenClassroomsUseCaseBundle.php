<?php

namespace OpenClassrooms\Bundle\UseCaseBundle;

use OpenClassrooms\Bundle\UseCaseBundle\DependencyInjection\Compiler\UseCaseProxyPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class OpenClassroomsUseCaseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new UseCaseProxyPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
