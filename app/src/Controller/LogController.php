<?php

namespace App\Controller;

use App\Filter\AggregatedLogFilter;
use App\Repository\AggregatedLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    public function __construct(private AggregatedLogRepository $logRepository)
    {

    }

    #[Route('/count', name: 'app_count', methods: [Request::METHOD_GET])]
    public function index(AggregatedLogFilter $filter): JsonResponse
    {
        $result = $this->logRepository->findLogsByFilter($filter);
        return $this->json($result);
    }
}
