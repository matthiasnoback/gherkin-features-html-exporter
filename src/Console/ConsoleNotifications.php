<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\Console;

use GherkinHtmlExporter\Notifications;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsoleNotifications implements Notifications
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function htmlFileWasCreated(string $filePath): void
    {
        $this->output->writeln(sprintf('Created HTML file <info>%s</info>', $filePath));
    }

    public function done(): void
    {
    }
}
