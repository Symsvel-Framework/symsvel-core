<?php

declare(strict_types=1);

namespace SymSvel\Core\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiResponse
{
    public static function success(mixed $data, int $status = 200): JsonResponse
    {
        if ($status < 200 || $status >= 300 || 204 === $status) {
            throw new \InvalidArgumentException('Invalid success status.');
        }

        return new JsonResponse(['data' => $data], $status);
    }

    public static function noContent(): JsonResponse
    {
        return new JsonResponse('', 204, [], true);
    }

    /** @param array<string, string> $violations */
    public static function error(string $code, string $message, int $status, array $violations = []): JsonResponse
    {
        if ($status < 400 || $status >= 600 || '' === trim($code) || '' === trim($message)) {
            throw new \InvalidArgumentException('Invalid API error.');
        }
        if (422 === $status && [] === $violations) {
            throw new \InvalidArgumentException('HTTP 422 requires field violations.');
        }
        if (422 !== $status && [] !== $violations) {
            throw new \InvalidArgumentException('Field violations are reserved for HTTP 422.');
        }

        $error = ['code' => $code, 'message' => $message];
        if (422 === $status) {
            $error['violations'] = $violations;
        }

        return new JsonResponse(['error' => $error], $status);
    }
}
