<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Node\FeatureNode;
use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;

final class LayoutHtmlNode implements HtmlNode
{
    /**
     * @var array<FeatureNode>
     */
    private array $features;
    private ?string $stylesheet;
    private string $title;

    /**
     * @param array<FeatureNode> $features
     */
    public function __construct(array $features, ?string $stylesheet, string $title)
    {
        $this->features = $features;
        $this->stylesheet = $stylesheet;
        $this->title = $title;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">',
                new ReplaceVariablesNode('<title>{title}</title>', ['title' => $this->title]),
                $this->stylesheet === null ? null
                    : new ReplaceVariablesNode(
                    '<link rel="stylesheet" href="{stylesheet}">',
                    ['stylesheet' => $this->stylesheet]
                ),
                '</head><body>',
                new TableOfContentsHtmlNode($this->features),
                new FeaturesHtmlNode($this->features),
                '</body></html>'
            ]
        );
    }
}
