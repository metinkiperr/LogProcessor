<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Filter\AggregatedLogFilter;
use App\Service\AggregatedLogFilterDenormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class AggregatedLogFilterResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === AggregatedLogFilter::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $queryParameters = $request->query->all();

        $serializer = new Serializer([new AggregatedLogFilterDenormalizer()], [new JsonEncoder()]);

        yield $serializer->denormalize($queryParameters, AggregatedLogFilter::class, 'json');
    }
}
