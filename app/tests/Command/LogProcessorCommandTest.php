<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\LogProcessorCommand;
use App\Entity\AggregatedLog;
use App\Repository\AggregatedLogRepository;
use App\Service\AggregatedLogService;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class LogProcessorCommandTest extends KernelTestCase
{
    /**
     * @test
     */
    public function execute()
    {
        $application = new Application();
        $command = new LogProcessorCommand(self::getContainer()->get(AggregatedLogService::class));

        $application->add($command);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'path' => '/var/www/loganalytics/tests/Resources/test.log'
        ]);

        $output = $commandTester->getDisplay();
        $repository = static::getContainer()->get(AggregatedLogRepository::class);

        /** @var AggregatedLog $testLog */
        $testLog = $repository->findOneBy(['service' => 'TEST-SERVICE', 'httpMethod' => Request::METHOD_HEAD]);

        $this->assertEquals(Response::HTTP_CREATED, $testLog->getStatusCode());
        $this->assertEquals('test', $testLog->getEndpoint());
        $this->assertStringContainsString('', $output);
    }
}
