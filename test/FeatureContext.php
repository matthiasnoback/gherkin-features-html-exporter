<?php

namespace Test;

use Behat\Behat\Context\Context;
use GherkinHtmlExporter\FeatureExporter;
use PHPUnit\Framework\Assert;
use function Safe\preg_replace;
use function Safe\file_get_contents;

final class FeatureContext implements Context
{
    private string $projectRootDir;
    private FeatureExporter $exporter;
    private string $exportDir;

    private ?string $featureDirectory = null;
    private ?string $currentFilePath = null;

    public function __construct()
    {
        $this->projectRootDir = sys_get_temp_dir() . '/' . uniqid('project');
        mkdir($this->projectRootDir);

        $this->exportDir = sys_get_temp_dir() . '/' . uniqid('export');
        mkdir($this->exportDir);

        $this->exporter = FeatureExporter::createWithDependencies();
    }

    /**
     * @Given the directory :directory has a file called :file containing:
     */
    public function directoryContainsFile(string $directory, string $file, string $contents): void
    {
        $this->featureDirectory = $this->projectRootDir . '/' . $directory;
        mkdir($this->featureDirectory);

        $contents = str_replace("'''" , '"""', $contents);

        file_put_contents($this->featureDirectory . '/' . $file, $contents);
    }

    /**
     * @Given this directory has a file called :file containing:
     */
    public function thisDirectoryContainsFile(string $file, string $contents): void
    {
        assert(is_string($this->featureDirectory));

        file_put_contents($this->featureDirectory . '/' . $file, $contents);
    }

    /**
     * @When I export this directory to HTML
     * @When I export this directory to HTML providing the tag :tag
     * @When I export this directory to HTML providing the tag :tag and the stylesheet :stylesheet
     * @When I export this directory to HTML providing the tag :tag and merge to :merge
     */
    public function export(?string $tag = null, ?string $stylesheet = null, ?string $merge = null): void
    {
        assert(is_string($this->featureDirectory));

        $this->exporter->exportDirectory($this->featureDirectory, $this->exportDir, $tag, $stylesheet, false, $merge);
    }

    /**
     * @Then the export directory should have a file called :expectedFile containing:
     */
    public function exportDirectoryShouldContainHtmlFile(string $expectedFile, string $expectedContents): void
    {
        $filePath = $this->exportDir . '/' . $expectedFile;
        Assert::assertFileExists($filePath);
        $this->currentFilePath = $filePath;

        $this->assertHtmlFileContains($filePath, $expectedContents);
    }

    /**
     * @Then this file should also contain:
     */
    public function thisFileShouldAlsoContain(string $expectedContents): void
    {
        assert(is_string($this->currentFilePath));

        $this->assertHtmlFileContains($this->currentFilePath, $expectedContents);
    }

    /**
     * @Then the file :expectedFile should not contain :expectedContents
     */
    public function fileShouldNotContain(string $expectedFile, string $expectedContents): void
    {
        $filePath = $this->exportDir . '/' . $expectedFile;
        Assert::assertFileExists($filePath);
        $actualContents = file_get_contents($filePath);

        $this->assertHtmlNotContains(
            $expectedContents,
            $actualContents
        );
    }

    private function assertHtmlContains(string $expected, string $actual): void
    {
        $expected = $this->reformatHtml($expected);
        $actual = $this->reformatHtml($actual);

        Assert::assertStringContainsString(
            $this->reformatHtml($expected),
            $this->reformatHtml($actual),
            "Expected:\n\n{$expected}\n\nActual:{$actual}"
        );
    }

    private function assertHtmlNotContains(string $expected, string $actual): void
    {
        $expected = $this->reformatHtml($expected);
        $actual = $this->reformatHtml($actual);

        Assert::assertStringNotContainsString(
            $expected,
            $actual,
            "Expected:\n\n{$expected}\n\nActual:{$actual}"
        );
    }

    private function reformatHtml(string $originalHtml): string
    {
        // A silly, yet effective way of removing whitespace between HTML elements:
        $cleanedUpHtml = preg_replace('/(>)([\s]*)(<)/', "$1\n$3", $originalHtml);
        assert(is_string($cleanedUpHtml));

        return trim($cleanedUpHtml);
    }

    private function assertHtmlFileContains(string $filePath, string $expectedContents): void
    {
        $actualContents = file_get_contents($filePath);

        $this->assertHtmlContains(
            $expectedContents,
            $actualContents
        );
    }
}
