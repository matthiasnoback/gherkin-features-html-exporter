<?php

namespace Test;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use GherkinHtmlExporter\FeatureExporter;
use PHPUnit\Framework\Assert;
use function preg_replace;

final class FeatureContext implements Context
{
    private string $projectRootDir;
    private FeatureExporter $exporter;
    private string $exportDir;

    private ?string $featureDirectory = null;

    public function __construct()
    {
        $this->projectRootDir = sys_get_temp_dir() . '/' . uniqid('project');
        mkdir($this->projectRootDir);

        $this->exportDir = sys_get_temp_dir() . '/' . uniqid('export');
        mkdir($this->exportDir);

        $this->exporter = new FeatureExporter();
    }

    /**
     * @Given the directory :directory has a file called :file containing:
     */
    public function directoryContainsFile(string $directory, string $file, string $contents): void
    {
        $this->featureDirectory = $this->projectRootDir . '/' . $directory;
        mkdir($this->featureDirectory);

        file_put_contents($this->featureDirectory . '/' . $file, $contents);
    }

    /**
     * @When I export this directory to HTML
     */
    public function export(): void
    {
        $this->exporter->exportDirectory($this->featureDirectory, $this->exportDir);
    }

    /**
     * @Then the export directory should have a file called :expectedFile containing:
     */
    public function exportDirectoryShouldContainHtmlFile(string $expectedFile, string $expectedContents): void
    {
        $filePath = $this->exportDir . '/' . $expectedFile;
        Assert::assertFileExists($filePath);
        $actualContents = file_get_contents($filePath);

        $this->assertHtmlEquals(
            $expectedContents,
            $actualContents
        );
    }

    private function assertHtmlEquals(string $expected, string $actual): void
    {
        Assert::assertEquals(
            $this->reformatHtml($expected),
            $this->reformatHtml($actual)
        );
    }

    private function reformatHtml(string $originalHtml): string
    {
        // A silly, yet effective way of removing whitespace between HTML elements:
        return trim(preg_replace('/(\>)([\s]+)(\<)/', '$1$3', $originalHtml));
    }
}
