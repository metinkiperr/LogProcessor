<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AggregatedLog;
use App\Factory\AggregatedLogFactory;
use App\Repository\AggregatedLogRepository;

final class AggregatedLogService
{
    public function __construct(private AggregatedLogRepository $aggregatedLogRepository)
    {

    }

    private function parseAggregatedLog(string $logEntry): array
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

    public function persistLogData(string $logEntry): void
    {
        $logData = $this->parseAggregatedLog($logEntry);
        $log = AggregatedLogFactory::createAggregatedLog($logData);
        $this->aggregatedLogRepository->save($log);
    }
}
