<?php
declare(strict_types=1);

use Behat\Gherkin\Node\FeatureNode;
use GherkinHtmlExporter\Html;

/** @var FeatureNode[] $features */
/** @var string $tag */

$title = $tag . ' features';

require __DIR__ . '/_header.html.php';

if (count($features) > 1) {
    ?>
    <div class="table-of-contents">
        <div class="table-of-contents-title">Table of contents</div>
        <ul>
            <?php foreach ($features as $feature) {
                ?>
                <li>
                    <a href="#<?php
                    echo md5(basename($feature->getFile()) . $feature->getLine());
                    ?>"><?php echo Html::escape(ucfirst($feature->getTitle())); ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
}

foreach ($features as $feature) {
    require __DIR__ . '/_feature.html.php';
}

require __DIR__ . '/_footer.html.php';
