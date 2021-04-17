<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

interface Notifications
{
    public function htmlFileWasCreated(string $filePath): void;
}
