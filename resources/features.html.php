<?php
declare(strict_types=1);

use Behat\Gherkin\Node\FeatureNode;

/** @var FeatureNode[] $features */
/** @var string $tag */

$title = $tag . ' features';

require __DIR__  . '/_header.html.php';

foreach ($features as $feature) {
    require __DIR__ . '/_feature.html.php';
}

require __DIR__  . '/_footer.html.php';
