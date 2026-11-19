<?php

declare(strict_types=1);

namespace SymSvel\Core\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Attribute\Route;
use SymSvel\Core\Controller\HealthController;

final class HealthControllerTest extends TestCase
{
    public function testLivenessIsIndependentOfOptionalInfrastructure(): void
    {
        $response = (new HealthController())();

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(
            ['data' => ['status' => 'ok']],
            json_decode((string) $response->getContent(), true, 512, JSON_THROW_ON_ERROR),
        );
        self::assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }

    public function testExposesOnlyThePublicGetHealthRoute(): void
    {
        $method = new \ReflectionMethod(HealthController::class, '__invoke');
        $routes = $method->getAttributes(Route::class);
        self::assertCount(1, $routes);
        // Symfony's #[Route] is a metadata attribute, not a Routing\\Route instance.
        $arguments = $routes[0]->getArguments();
        self::assertSame('/api/health', $arguments[0]);
        self::assertSame(['GET'], $arguments['methods']);
    }
}
