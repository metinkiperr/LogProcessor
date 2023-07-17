<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AggregatedLog;
use App\Filter\AggregatedLogFilter;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

class AggregatedLogRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AggregatedLog::class);
    }

    public function findLogsByFilter(AggregatedLogFilter $filter): int
    {
        $queryBuilder = $this->createQueryBuilder('log');
        $criteria = Criteria::create();

        if (!empty($filter->getServiceNames())) {
            $criteria->andWhere(Criteria::expr()->in('log.service', $filter->getServiceNames()));
        }

        if ($filter->getStatusCode() !== null) {
            $criteria->andWhere(Criteria::expr()->eq('log.statusCode', $filter->getStatusCode()));
        }

        if ($filter->getStartDate() !== null) {
            $criteria->andWhere(Criteria::expr()->gte('log.createdAt', $filter->getStartDate()));
        }

        if ($filter->getEndDate() !== null) {
            $criteria->andWhere(Criteria::expr()->lte('log.createdAt', $filter->getEndDate()));
        }

        $queryBuilder->addCriteria($criteria);

        $logs = $queryBuilder->getQuery()->getResult();

        return count($logs);
    }
}
