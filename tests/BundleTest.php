<?php

declare(strict_types=1);

namespace SymSvel\Core\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymSvel\Core\SymSvelCoreBundle;

final class BundleTest extends TestCase
{
    public function testBundleIsSymfonyBundle(): void
    {
        self::assertInstanceOf(Bundle::class, new SymSvelCoreBundle());
    }
}
