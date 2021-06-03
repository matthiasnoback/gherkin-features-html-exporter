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
use Gajus\Dindent\Indenter;
use GherkinHtmlExporter\Console\ConsoleNotifications;
use GherkinHtmlExporter\HtmlNode\LayoutHtmlNode;
use League\CommonMark\CommonMarkConverter;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Console\Output\OutputInterface;

final class FeatureExporter
{
    private GherkinParser $parser;
    private Notifications $notifications;
    private HtmlPrinter $htmlPrinter;
    private HtmlFormatter $htmlFormatter;

    public static function createWithDependencies(?OutputInterface $outputInterface = null): self
    {
        // Copied from \Codeception\Test\Loader\Gherkin
        $gherkin = new ReflectionClass(Gherkin::class);
        $gherkinClassFileName = $gherkin->getFileName();
        assert(is_string($gherkinClassFileName));

        $gherkinClassPath = dirname($gherkinClassFileName);
        $i18n = require $gherkinClassPath . '/../../../i18n.php';
        $keywords = new GherkinKeywords($i18n);
        $lexer = new GherkinLexer($keywords);
        $gherkinParser = new GherkinParser($lexer);

        $htmlFormatter = new HtmlFormatterUsingLibrary();

        return new self(
            $gherkinParser,
            new HtmlPrinter(
                new CommonMarkConverter()
            ),
            $htmlFormatter,
            new ConsoleNotifications($outputInterface)
        );
    }

    public function __construct(
        GherkinParser $parser,
        HtmlPrinter $htmlPrinter,
        HtmlFormatter $htmlFormatter,
        Notifications $notifications
    ) {
        $this->parser = $parser;
        $this->htmlPrinter = $htmlPrinter;
        $this->notifications = $notifications;
        $this->htmlFormatter = $htmlFormatter;
    }

    public function exportDirectory(
        string $featuresDirectory,
        string $targetDirectory,
        ?string $tag,
        ?string $stylesheet,
        bool $reformatHtml,
        bool $merge = false
    ): void {
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $gherkin = new Gherkin();
        $gherkin->addLoader(new DirectoryLoader($gherkin));
        $gherkin->addLoader(new GherkinFileLoader($this->parser));
        if (is_string($tag)) {
            $gherkin->addFilter(new TagFilter($tag));
        }
        /** @var FeatureNode[] $features */
        $features = $gherkin->load($featuresDirectory);

        if (is_string($tag)) {
            $this->exportAllFeaturesToSingleFile($features, $targetDirectory, $tag, $stylesheet, $reformatHtml);
        } elseif ($merge) {
            $this->exportAllFeaturesToSingleFile($features, $targetDirectory, 'index', $stylesheet, $reformatHtml);
        } else {
            $this->exportAllFeaturesSeparately($features, $targetDirectory, $stylesheet, $reformatHtml);
        }

        $this->notifications->done();
    }

    /**
     * @param array<FeatureNode> $features
     */
    private function exportAllFeaturesToSingleFile(
        array $features,
        string $targetDirectory,
        string $tag,
        ?string $stylesheet,
        bool $reformat
    ): void {
        $html = $this->printFeaturesAsHtml($features, $stylesheet, $tag . ' features', $reformat);

        $targetFilePath = $targetDirectory . '/' . $tag . '.html';

        file_put_contents($targetFilePath, $html);

        $this->notifications->htmlFileWasCreated($targetFilePath);
    }

    /**
     * @param array<FeatureNode> $features
     */
    private function exportAllFeaturesSeparately(
        array $features,
        string $targetDirectory,
        ?string $stylesheet,
        bool $reformat
    ): void {
        foreach ($features as $feature) {
            $html = $this->printFeaturesAsHtml([$feature], $stylesheet, $feature->getTitle() ?? 'Feature', $reformat);

            $featureFile = $feature->getFile();
            assert(is_string($featureFile));
            $sourceFile = new SplFileInfo($featureFile);
            $fileNameWithoutExtension = $sourceFile->getBasename('.feature');

            $targetFilePath = $targetDirectory . '/' . $fileNameWithoutExtension . '.html';

            file_put_contents($targetFilePath, $html);

            $this->notifications->htmlFileWasCreated($targetFilePath);
        }
    }

    /**
     * @param array<FeatureNode> $features
     */
    private function printFeaturesAsHtml(array $features, ?string $stylesheet, string $title, bool $reformat): string
    {
        $html = $this->htmlPrinter->nodeToHtml(
            new LayoutHtmlNode(
                $features,
                $stylesheet,
                $title
            )
        );

        if ($reformat) {
            $html = $this->htmlFormatter->reformatHtml($html);
        }

        return $html;
    }
}
