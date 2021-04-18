#!/usr/bin/env php
<?php
declare(strict_types=1);

use GherkinHtmlExporter\Console\ExportFeaturesCommand;
use Symfony\Component\Console\Application;

$projectRootDir = null;

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $autoloadFile) {
    if (file_exists($autoloadFile)) {
        $autoloadFile = realpath($autoloadFile);
        $projectRootDir = dirname(dirname($autoloadFile));
        require $autoloadFile;

        break;
    }
}

if ($projectRootDir === null) {
    throw new RuntimeException('Could not find autoload.php');
}

$application = new Application('Gherkin features exporter');
$application->addCommands(
    [
        new ExportFeaturesCommand()
    ]
);
$application->setDefaultCommand('gherkin:export-features', true);
$application->run();
