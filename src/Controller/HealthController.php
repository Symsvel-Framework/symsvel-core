<?php

declare(strict_types=1);

namespace SymSvel\Core\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use SymSvel\Core\Http\ApiResponse;

/**
 * Lightweight HTTP liveness. This is not a database/queue/mail readiness probe.
 */
final class HealthController
{
    #[Route('/api/health', name: 'symsvel_core_liveness', methods: ['GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $response = ApiResponse::success(['status' => 'ok']);
        $response->headers->set('Cache-Control', 'no-store');

        return $response;
    }
}
