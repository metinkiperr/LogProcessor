<?php

declare(strict_types=1);

namespace App\Service;

use App\Filter\AggregatedLogFilter;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AggregatedLogFilterDenormalizer implements DenormalizerInterface
{
    public function denormalize(
        mixed  $data,
        string $type,
        string $format = null,
        array  $context = [],
    ): AggregatedLogFilter {
        $filter = new AggregatedLogFilter();

        if (!empty($data['serviceNames'])) {
            $filter->serviceNames = $data['serviceNames'];
        }

        if (!empty($data['statusCode'])) {

            $filter->statusCode = (int) $data['statusCode'];
        }

        if (!empty($data['startDate'])) {
            $filter->startDate = new \DateTimeImmutable($data['startDate']);
        }

        if (!empty($data['endDate'])) {
            $filter->endDate = new \DateTimeImmutable($data['endDate']);
        }

        return $filter;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === AggregatedLogFilter::class;
    }
}
