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

    public function __construct()
    {
        // Copied from \Codeception\Test\Loader\Gherkin
        $gherkin = new ReflectionClass(Gherkin::class);
        $gherkinClassPath = dirname($gherkin->getFileName());
        $i18n = require $gherkinClassPath . '/../../../i18n.php';
        $keywords = new GherkinKeywords($i18n);
        $lexer = new GherkinLexer($keywords);
        $this->parser = new GherkinParser($lexer);
    }

    public function exportDirectory(string $featuresDirectory, string $targetDirectory, ?string $tag): void
    {
        $gherkin = new Gherkin();
        $gherkin->addLoader(new DirectoryLoader($gherkin));
        $gherkin->addLoader(new GherkinFileLoader($this->parser));
        if (is_string($tag)) {
            $gherkin->addFilter(new TagFilter($tag));
        }
        /** @var FeatureNode[] $features */
        $features = $gherkin->load($featuresDirectory);

        if (is_string($tag)) {
            $this->exportAllFeaturesToSingleFile($features, $targetDirectory, $tag);
        } else {
            $this->exportAllFeaturesSeparately($features);
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

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    private function exportAllFeaturesToSingleFile(array $features, string $targetDirectory, string $tag): void
    {
        $html = $this->renderTemplate(
            __DIR__ . '/../resources/features.html.php',
            [
                'features' => $features
            ]
        );

        $targetFilePath = $targetDirectory . '/' . $tag . '.html';

        file_put_contents($targetFilePath, $html);
    }

    private function exportAllFeaturesSeparately(array $features): void
    {
        foreach ($features as $feature) {
            $html = $this->renderTemplate(
                __DIR__ . '/../resources/feature.html.php',
                [
                    'feature' => $feature
                ]
            );

            $targetFilePath = str_replace('.feature', '.html', $feature->getFile());
            $targetFile = $targetFilePath;

            file_put_contents($targetFile, $html);
        }
    }
}
