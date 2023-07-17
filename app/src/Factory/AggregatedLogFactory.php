<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AggregatedLog;

class AggregatedLogFactory
{
    public static function createAggregatedLog(array $logData): AggregatedLog
    {
        $aggregatedLog = new AggregatedLog();
        $aggregatedLog->setService($logData['service']);
        $aggregatedLog->setCreatedAt($logData['createdAt']);
        $aggregatedLog->setEndpoint($logData['endpoint']);
        $aggregatedLog->setStatusCode($logData['statusCode']);
        $aggregatedLog->setHttpMethod($logData['method']);

        return $aggregatedLog;
    }
}
