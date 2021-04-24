<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\HtmlPrinter;
use function strtr;

final class ReplaceVariablesNode implements HtmlNode
{
    private string $template;

    /**
     * @var array<string,string>
     */
    private array $variables;

    /**
     * @param array<string,string> $variables
     */
    public function __construct(string $template, array $variables)
    {
        $this->template = $template;
        $this->variables = $variables;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        $replacements = [];
        foreach ($this->variables as $key => $value) {
            $replacements['{' . $key . '}'] = $htmlPrinter->escape($value);
        }

        return strtr($this->template, $replacements);
    }
}
