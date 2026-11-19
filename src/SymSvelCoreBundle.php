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
        // Back imports Symfony's built-in `routing.controllers` resource.
        // Expose Core's liveness action through that native service tag.
        $builder->register(HealthController::class, HealthController::class)
            ->addTag('controller.service_arguments')
            ->addTag('routing.controller');
    }
}
