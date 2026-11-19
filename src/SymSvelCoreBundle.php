<?php

declare(strict_types=1);

namespace SymSvel\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use SymSvel\Core\Controller\HealthController;

final class SymSvelCoreBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->register(HealthController::class, HealthController::class)
            ->addTag('controller.service_arguments');
    }
}
