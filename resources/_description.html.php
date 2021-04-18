<?php
declare(strict_types=1);

/** @var ?string $description */
assert(is_string($description) || $description === null);

if (is_string($description)) {
    ?>
    <div class="description">
        <?php echo \GherkinHtmlExporter\Html::markdownToHtml($description); ?>
    </div>
    <?php
}
