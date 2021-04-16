<?php
declare(strict_types=1);

use Behat\Gherkin\Node\FeatureNode;

/** @var FeatureNode[] $features */

foreach ($features as $feature) {
    require __DIR__ . '/feature.html.php';
}
