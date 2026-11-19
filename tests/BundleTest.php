<?php

declare(strict_types=1);

namespace SymSvel\Core\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymSvel\Core\Controller\HealthController;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymSvel\Core\SymSvelCoreBundle;

final class BundleTest extends TestCase
{
    public function testBundleIsSymfonyBundle(): void
    {
        self::assertInstanceOf(Bundle::class, new SymSvelCoreBundle());
    }

    public function testHealthControllerIsRegisteredWithNativeSymfonyRouting(): void
    {
        $container = new ContainerBuilder();
        $extension = (new SymSvelCoreBundle())->getContainerExtension();
        self::assertNotNull($extension);
        $extension->load([[]], $container);

        self::assertTrue($container->hasDefinition(HealthController::class));
        $controller = $container->getDefinition(HealthController::class);
        self::assertTrue($controller->hasTag('controller.service_arguments'));
        self::assertTrue($controller->hasTag('routing.controller'));
    }
}
