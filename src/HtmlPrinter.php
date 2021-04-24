<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

final class HtmlPrinter
{
    public function nodeToHtml(HtmlNode $node): string
    {
        return $this->nodesToHtml([$node]);
    }

    /**
     * @param array<HtmlNode|string|array<HtmlNode|string>> $nodes
     */
    public function nodesToHtml(array $nodes): string
    {
        return implode(
            '',
            array_map(
                function ($node): string {
                    if ($node === null) {
                        return '';
                    }

                    if ($node instanceof HtmlNode) {
                        return $node->toHtml($this);
                    }

                    if (is_array($node)) {
                        return $this->nodesToHtml($node);
                    }

                    return $node;
                },
                $nodes
            )
        );
    }

    public function markdownToHtml(string $markdown): string
    {
        // TODO inject Markdown converter
        return Html::markdownToHtml($markdown);
    }

    public function escape(string $string): string
    {
        return Html::escape($string);
    }
}
