<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\Console;

use GherkinHtmlExporter\FeatureExporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Test\EchoNotifications;

final class ExportFeaturesCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('gherkin:export-features')
            ->addArgument('featuresDirectory', InputArgument::REQUIRED)
            ->addArgument('targetDirectory', InputArgument::REQUIRED)
            ->addOption('tag', 't', InputOption::VALUE_REQUIRED)
            ->addOption('stylesheet', 's', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exporter = new FeatureExporter(new EchoNotifications());

        $exporter->exportDirectory(
            $input->getArgument('featuresDirectory'),
            $input->getArgument('targetDirectory'),
            $input->getOption('tag'),
            $input->getOption('stylesheet')
        );

        return 0;
    }
}
