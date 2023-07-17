<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Filter\AggregatedLogFilter;
use App\Service\AggregatedLogFilterDenormalizer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AggregatedLogFilterDenormalizerTest extends KernelTestCase
{
    /**
     * @test
     */
    public function denormalize()
    {
        $denormalizer = new AggregatedLogFilterDenormalizer();

        $data = [
            'serviceNames' => ['USER-SERVICE'],
            'statusCode' => '200',
            'startDate' => '2022-01-01T00:00:00+00:00',
            'endDate' => '2022-01-31T00:00:00+00:00',
        ];

        $expectedFilter = new AggregatedLogFilter();
        $expectedFilter->serviceNames = ['USER-SERVICE'];
        $expectedFilter->statusCode = 200;
        $expectedFilter->startDate = new \DateTimeImmutable('2022-01-01T00:00:00+00:00');
        $expectedFilter->endDate = new \DateTimeImmutable('2022-01-31T00:00:00+00:00');

        $result = $denormalizer->denormalize($data, AggregatedLogFilter::class, 'json');

        $this->assertEquals($expectedFilter, $result);
    }

    /**
     * @test
     */
    public function supportsDenormalization()
    {
        $denormalizer = new AggregatedLogFilterDenormalizer();

        $data = ['serviceNames' => ['USER-SERVICE'], 'statusCode' => '200'];

        $this->assertTrue($denormalizer->supportsDenormalization($data, AggregatedLogFilter::class, 'json'));
    }
}
