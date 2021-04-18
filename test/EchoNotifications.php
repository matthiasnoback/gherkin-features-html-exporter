<?php
declare(strict_types=1);

namespace Test;

use GherkinHtmlExporter\Notifications;

final class EchoNotifications implements Notifications
{
    public function htmlFileWasCreated(string $filePath): void
    {
        $this->println(sprintf('Created HTML file "%s"', $filePath));
    }

    private function println(string $line): void
    {
        echo $line . "\n";
    }

    public function done(): void
    {
    }
}
