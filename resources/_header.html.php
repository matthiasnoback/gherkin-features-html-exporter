<?php
declare(strict_types=1);

/** @var string $title */
/** @var ?string $stylesheet */

use GherkinHtmlExporter\Html;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Html::escape($title); ?></title>
<?php if (is_string($stylesheet)) {
    ?>
<link rel="stylesheet" href="<?php echo $stylesheet; ?>">
    <?php
}
?>
</head>
<body>
