<?php

declare(strict_types=1);

namespace App\Service;

final class AggregatedLogService
{
    public function parseAggregatedLog(string $logEntry): array
    {
        $pattern = '/([\w-]+) - - \[(.+)\] "(.+)" (\d+)/';
        preg_match($pattern, $logEntry, $matches);

        $service = $matches[1];
        $createdAt = \DateTimeImmutable::createFromFormat('d/M/Y:H:i:s O', $matches[2]);
        $statusCode = (int)$matches[4];
        $endpoint = explode(' ', $matches[3]);

        return [
            'service' => $service,
            'createdAt' => $createdAt,
            'statusCode' => $statusCode,
            'method' => $endpoint[0],
            'endpoint' => trim($endpoint[1], '/'),
        ];
    }
}
