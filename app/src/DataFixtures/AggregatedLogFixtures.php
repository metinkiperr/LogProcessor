<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\AggregatedLogFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class AggregatedLogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $logs = [
            [
                'service' => 'USER-SERVICE',
                'statusCode' => 200,
                'createdAt' => new \DateTimeImmutable('2022-01-01'),
                'endpoint' => 'users',
                'method' => Request::METHOD_POST
            ],
            [
                'service' => 'USER-SERVICE',
                'statusCode' => 400,
                'createdAt' => new \DateTimeImmutable('2022-01-01'),
                'endpoint' => 'users',
                'method' => Request::METHOD_POST
            ],
            [
                'service' => 'INVOICE-SERVICE',
                'statusCode' => 200,
                'createdAt' => new \DateTimeImmutable('2022-01-02'),
                'endpoint' => 'users',
                'method' => Request::METHOD_POST
            ],
            [
                'service' => 'INVOICE-SERVICE',
                'statusCode' => 400,
                'createdAt' => new \DateTimeImmutable('2022-01-03'),
                'endpoint' => 'users',
                'method' => Request::METHOD_POST
            ],
            [
                'service' => 'INVOICE-SERVICE',
                'statusCode' => 401,
                'createdAt' => new \DateTimeImmutable('2022-01-04'),
                'endpoint' => 'users',
                'method' => Request::METHOD_POST
            ],
        ];

        foreach ($logs as $logData) {
            $log = AggregatedLogFactory::createAggregatedLog($logData);

            $manager->persist($log);
        }

        $manager->flush();
    }
}
