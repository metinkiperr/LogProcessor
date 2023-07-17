<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\AggregatedLogFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function index(
        ?array $serviceNames,
        ?int $statusCode,
        ?string $startDate,
        ?string $endDate,
        int $expectedCount
    ) {
        static::ensureKernelShutdown();
        $client = $this->createClient();
        $this->databaseTool->loadFixtures([
            AggregatedLogFixtures::class
        ]);

        $client->request(
            method: Request::METHOD_GET,
            uri: '/count',
            parameters: [
            'serviceNames' => $serviceNames,
            'statusCode' => $statusCode,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]
        );

        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $responseData = json_decode($response->getContent(), true);

        $this->assertSame($expectedCount, $responseData);
    }


    /**
     * @dataProvider
     */
    public function dataProvider(): array
    {
        return [
            'valid request with empty query' => [
                null,
                null,
                null,
                null,
                5,
            ],
            'valid request with empty service name' => [
                null,
                null,
                null,
                null,
                5,
            ],
            'valid request with both service names' => [
                ['USER-SERVICE', 'INVOICE-SERVICE'],
                null,
                null,
                null,
                5,
            ],
            'valid request with only status code' => [
                null,
                Response::HTTP_OK,
                null,
                null,
                2,
            ],
            'valid request with only start date' => [
                null,
                null,
                '2022-01-01',
                null,
                5,
            ],
            'valid request with only end date' => [
                null,
                null,
                null,
                '2022-01-01',
                2,
            ],
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
