<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

final class TitleAndDescription
{
    private ?string $title;
    private ?string $description;

    public function __construct(?string $title, ?string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public static function fromScenarioTitle(?string $title): self
    {
        if ($title === null) {
            return new self(null, null);
        }

        // Scenario title also contains the description
        $title = trim($title);

        if (strpos($title, "\n") === false) {
            return new self($title, null);
        }

        $lines = explode("\n", $title);
        $title = array_shift($lines);

        return new self($title, implode("\n", $lines));
    }
}
