<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\Html;
use GherkinHtmlExporter\HtmlPrinter;
use function strtr;

final class ReplaceVariablesNode implements HtmlNode
{
    private string $template;
    private array $variables;

    public function __construct(string $template, array $variables)
    {
        $this->template = $template;
        $this->variables = $variables;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        $replacements = [];
        foreach ($this->variables as $key => $value) {
            $replacements['{' . $key . '}'] = Html::escape($value);
        }

        return strtr($this->template, $replacements);
    }
}