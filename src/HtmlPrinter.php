<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use GherkinHtmlExporter\HtmlNode\HtmlNode;
use League\CommonMark\MarkdownConverterInterface;

final class HtmlPrinter
{
    private MarkdownConverterInterface $markdownConverter;

    public function __construct(MarkdownConverterInterface $markdownConverter)
    {
        $this->markdownConverter = $markdownConverter;
    }

    public function nodeToHtml(HtmlNode $node): string
    {
        return $this->nodesToHtml([$node]);
    }

    /**
     * @param array<HtmlNode|string|null|array<HtmlNode|string|null>> $nodes
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
        return $this->markdownConverter->convertToHtml($markdown);
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }
}
