<?php

declare(strict_types=1);

namespace App\Filter;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class AggregatedLogFilter
{
    #[SerializedName("serviceNames")]
    #[Assert\Type(type: Types::SIMPLE_ARRAY)]
    public ?array $serviceNames = [];

    #[SerializedName("statusCode")]
    #[Assert\Type(type: Types::INTEGER)]
    public ?int $statusCode = null;

    #[SerializedName("startDate")]
    #[Assert\DateTime]
    public ?\DateTimeImmutable $startDate = null;

    #[SerializedName("endDate")]
    #[Assert\DateTime]
    public ?\DateTimeImmutable $endDate = null;

    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }


    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
