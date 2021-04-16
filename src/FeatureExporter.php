<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Gherkin;
use Behat\Gherkin\Keywords\ArrayKeywords as GherkinKeywords;
use Behat\Gherkin\Lexer as GherkinLexer;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Parser as GherkinParser;
use RuntimeException;
use Symfony\Component\Finder\Finder;

final class FeatureExporter
{
    private GherkinParser $parser;

    public function __construct()
    {
        // Copied from \Codeception\Test\Loader\Gherkin
        $gherkin = new \ReflectionClass(Gherkin::class);
        $gherkinClassPath = dirname($gherkin->getFileName());
        $i18n = require $gherkinClassPath . '/../../../i18n.php';
        $keywords = new GherkinKeywords($i18n);
        $lexer = new GherkinLexer($keywords);
        $this->parser = new GherkinParser($lexer);
    }

    public function exportDirectory(string $featuresDirectory, string $targetDirectory): void
    {
        $featureFiles = Finder::create()->in($featuresDirectory)->name('*.feature');

        foreach ($featureFiles as $featureFile) {
            $featureNode = $this->parser->parse(file_get_contents($featureFile->getPathname()));
            assert($featureNode instanceof FeatureNode);

            $html = $this->renderTemplate(
                __DIR__ . '/../resources/feature.html.php',
                [
                    'feature' => $featureNode
                ]
            );

            $targetFile = $targetDirectory . '/' . $featureFile->getFilenameWithoutExtension() . '.html';

            file_put_contents(
                $targetFile,
                $html
            );
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
}
