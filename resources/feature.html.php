<?php
declare(strict_types=1);

use Behat\Gherkin\Node\FeatureNode;

/** @var FeatureNode $feature */

$title = $feature->getTitle();

require __DIR__  . '/_header.html.php';

require __DIR__ . '/_feature.html.php';

require __DIR__  . '/_footer.html.php';
