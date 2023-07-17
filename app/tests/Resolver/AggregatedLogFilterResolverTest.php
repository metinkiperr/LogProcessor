<?php

declare(strict_types=1);

namespace App\Tests\Resolver;

use App\Filter\AggregatedLogFilter;
use App\Resolver\AggregatedLogFilterResolver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class AggregatedLogFilterResolverTest extends KernelTestCase
{
    /**
     * @test
     */
    public function resolve()
    {
        $queryParameters = [
            'serviceNames' => ['USER-SERVICE'],
            'statusCode' => 200,
            'startDate' => '2022-01-01',
            'endDate' => '2022-01-31',
        ];

        $resolver = new AggregatedLogFilterResolver();
        $request = Request::create('/count', 'GET', $queryParameters);
        $argument = new ArgumentMetadata(
            'filter',
            AggregatedLogFilter::class,
            false,
            false,
            null
        );
        $result = $resolver->resolve($request, $argument);

        $resolved = iterator_to_array($result)[0];


        $this->assertSame(['USER-SERVICE'], $resolved->getServiceNames());
        $this->assertSame(Response::HTTP_OK, $resolved->getStatusCode());
        $this->assertSame(
            (new \DateTimeImmutable('2022-01-01'))->format('Y-m-d'),
            $resolved->getStartDate()->format('Y-m-d')
        );
        $this->assertSame(
            (new \DateTimeImmutable('2022-01-31'))->format('Y-m-d'),
            $resolved->getEndDate()->format('Y-m-d')
        );
    }
}
