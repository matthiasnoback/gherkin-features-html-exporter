<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Filter\TagFilter;
use Behat\Gherkin\Gherkin;
use Behat\Gherkin\Keywords\ArrayKeywords as GherkinKeywords;
use Behat\Gherkin\Lexer as GherkinLexer;
use Behat\Gherkin\Loader\DirectoryLoader;
use Behat\Gherkin\Loader\GherkinFileLoader;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Parser as GherkinParser;
use ReflectionClass;

final class FeatureExporter
{
    private GherkinParser $parser;
    private Notifications $notifications;

    public function __construct(Notifications $notifications)
    {
        // Copied from \Codeception\Test\Loader\Gherkin
        $gherkin = new ReflectionClass(Gherkin::class);
        $gherkinClassPath = dirname($gherkin->getFileName());
        $i18n = require $gherkinClassPath . '/../../../i18n.php';
        $keywords = new GherkinKeywords($i18n);
        $lexer = new GherkinLexer($keywords);
        $this->parser = new GherkinParser($lexer);

        $this->notifications = $notifications;
    }

    public function exportDirectory(string $featuresDirectory, string $targetDirectory, ?string $tag, ?string $relativeStylesheetPathName): void
    {
        $gherkin = new Gherkin();
        $gherkin->addLoader(new DirectoryLoader($gherkin));
        $gherkin->addLoader(new GherkinFileLoader($this->parser));
        if (is_string($tag)) {
            $gherkin->addFilter(new TagFilter($tag));
        }
        /** @var FeatureNode[] $features */
        $features = $gherkin->load($featuresDirectory);

        $stylesheetFilePath = null;
        if (is_string($relativeStylesheetPathName)) {
            $stylesheetFilePath = $featuresDirectory . '/' . $relativeStylesheetPathName;
            if (!is_file($stylesheetFilePath)) {
                $stylesheetFilePath = null;
            }
        }

        if (is_string($tag)) {
            $this->exportAllFeaturesToSingleFile($features, $targetDirectory, $tag, $stylesheetFilePath);
        } else {
            $this->exportAllFeaturesSeparately($features, $targetDirectory, $stylesheetFilePath);
        }
    }

    private function renderTemplate(string $templatePath, array $variables): string
    {
        ob_start();

        extract($variables);

        require $templatePath;

        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    private function exportAllFeaturesToSingleFile(array $features, string $targetDirectory, string $tag, ?string $stylesheet): void
    {
        $html = $this->renderTemplate(
            __DIR__ . '/../resources/features.html.php',
            [
                'features' => $features,
                'stylesheet' => $stylesheet,
                'tag' => $tag
            ]
        );

        $targetFilePath = $targetDirectory . '/' . $tag . '.html';

        file_put_contents($targetFilePath, $html);

        $this->notifications->htmlFileWasCreated($targetFilePath);
    }

    private function exportAllFeaturesSeparately(array $features, string $targetDirectory, ?string $stylesheet): void
    {
        foreach ($features as $feature) {
            $html = $this->renderTemplate(
                __DIR__ . '/../resources/feature.html.php',
                [
                    'feature' => $feature,
                    'stylesheet' => $stylesheet
                ]
            );

            $sourceFile = new \SplFileInfo($feature->getFile());
            $fileNameWithoutExtension = $sourceFile->getBasename('.feature');

            $targetFilePath = $targetDirectory . '/' . $fileNameWithoutExtension . '.html';

            file_put_contents($targetFilePath, $html);

            $this->notifications->htmlFileWasCreated($targetFilePath);
        }
    }
}
