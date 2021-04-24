<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\FeatureNode;
use GherkinHtmlExporter\HtmlPrinter;

final class TableOfContentsHtmlNode implements HtmlNode
{
    /**
     * @var array<FeatureNode>
     */
    private array $features;

    /**
     * @param array<FeatureNode> $features
     */
    public function __construct(array $features)
    {
        $this->features = $features;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if (count($this->features) === 0) {
            return '';
        }

        return $htmlPrinter->nodesToHtml(
            [
                '<div class="table-of-contents"><div class="title">Table of contents</div><ul>',
                array_map(
                    fn(FeatureNode $feature) => [
                        '<li>',
                        new ReplaceVariablesNode(
                            '<a href="#{anchor}">{title}</a>',
                            [
                                'anchor' => md5(basename($feature->getFile()) . $feature->getLine()),
                                'title' => ucfirst($feature->getTitle() ?? 'Feature')
                            ]
                        ),
                        '</li>',
                    ],
                    $this->features
                ),
                '</ul></div>'
            ]
        );
    }
}
