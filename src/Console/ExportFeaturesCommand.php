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
        $exporter = new FeatureExporter(new ConsoleNotifications($output));

        $featuresDirectory = $input->getArgument('featuresDirectory');
        assert(is_string($featuresDirectory));
        $output->writeln(sprintf('Features directory: <comment>%s</comment>', $featuresDirectory));

        $targetDirectory = $input->getArgument('targetDirectory');
        assert(is_string($targetDirectory));
        $output->writeln(sprintf('Target directory: <comment>%s</comment>', $targetDirectory));

        $tag = $input->getOption('tag');
        assert($tag === null || is_string($tag));
        if (is_string($tag)) {
            $output->writeln(sprintf('Filter by tag: <comment>%s</comment>', $tag));
        }

        $stylesheet = $input->getOption('stylesheet');
        assert($stylesheet === null || is_string($stylesheet));
        if (is_string($stylesheet)) {
            $output->writeln(sprintf('Applying stylesheet: <comment>%s</comment>', $stylesheet));
        }

        $exporter->exportDirectory(
            $featuresDirectory,
            $targetDirectory,
            $tag,
            $stylesheet
        );

        return 0;
    }
}
