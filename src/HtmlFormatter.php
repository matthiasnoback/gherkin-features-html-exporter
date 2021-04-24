<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

interface HtmlFormatter
{
    public function reformatHtml(string $html): string;
}
