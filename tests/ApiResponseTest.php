<?php

declare(strict_types=1);

namespace SymSvel\Core\Tests;

use PHPUnit\Framework\TestCase;
use SymSvel\Core\Http\ApiResponse;

final class ApiResponseTest extends TestCase
{
    public function testSuccessEnvelope(): void
    {
        $response = ApiResponse::success(['id' => 1], 201);
        self::assertSame(201, $response->getStatusCode());
        self::assertSame(['data' => ['id' => 1]], json_decode((string) $response->getContent(), true));
    }

    public function testNoContent(): void
    {
        $response = ApiResponse::noContent();
        self::assertSame(204, $response->getStatusCode());
        self::assertSame('', $response->getContent());
    }

    public function testValidationEnvelope(): void
    {
        $response = ApiResponse::error('VALIDATION_FAILED', 'role.invalid', 422, ['label' => 'Required']);
        self::assertSame(['error' => ['code' => 'VALIDATION_FAILED', 'message' => 'role.invalid', 'violations' => ['label' => 'Required']]], json_decode((string) $response->getContent(), true));
    }

    public function testValidationRequiresViolations(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ApiResponse::error('VALIDATION_FAILED', 'role.invalid', 422);
    }
}
