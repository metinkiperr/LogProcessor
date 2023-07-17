<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Factory\AggregatedLogFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AggregatedLogFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function createAggregatedLog()
    {
        $logData = [
            'service' => 'USER-SERVICE',
            'statusCode' => 200,
            'createdAt' => new \DateTimeImmutable('2022-01-01'),
            'endpoint' => 'users',
            'method' => Request::METHOD_POST
        ];

        $result = AggregatedLogFactory::createAggregatedLog($logData);

        $this->assertEquals($logData['service'], $result->getService());
        $this->assertEquals($logData['statusCode'], $result->getStatusCode());
        $this->assertEquals($logData['endpoint'], $result->getEndpoint());
        $this->assertEquals($logData['method'], $result->getHttpMethod());
        $this->assertEquals($logData['createdAt'], $result->getCreatedAt());
    }
}
