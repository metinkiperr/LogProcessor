<?php

declare(strict_types=1);

namespace App\Command;

use App\Factory\AggregatedLogFactory;
use App\Repository\AggregatedLogRepository;
use App\Service\AggregatedLogService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:log:processor',
    description: 'Reads the aggregated log file and saves it into a database.',
    aliases: ['app:lo:pro'],
    hidden: false,
)]
class LogProcessorCommand extends Command
{
    public function __construct(
        private AggregatedLogRepository $logRepository,
        private AggregatedLogService    $aggregatedLogService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to the log file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('Command Starts');
        $logFilePath = $input->getArgument('path');
        $logs = file($logFilePath, FILE_IGNORE_NEW_LINES);

        foreach ($logs as $log) {
            $logData = $this->aggregatedLogService->parseAggregatedLog($log);
            $log = AggregatedLogFactory::createAggregatedLog($logData);
            $this->logRepository->save($log);
        }

        return Command::SUCCESS;
    }
}
