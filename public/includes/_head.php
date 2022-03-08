<?php

$_description = $_description ?? getenv('APP_DESCRIPTION');

$app_title = getenv('APP_TITLE') ?: 'To-Do';
$title = $_title.' - '.$app_title;

?>

<!DOCTYPE html>
<html>
<head>
	<title><?= escape($title) ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= escape($_description) ?>">

    <link rel="icon" type="image/png" href="<?= ASSETS_URL ?>/img/favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <?php

    $theme_ext = isset($_theme) && $_theme === 'dark' ? '-dark' : '';
    $scheme = $_scheme ?? 'default';

    $libs = [
        'css/main.css'
    ];

    $libs = array_merge($libs, $_styles ?? []);
    foreach ($libs as $index => $path) {
        $class = null;
        if (is_array($path)) {
            $src = $path[0];
            $class = $path[1];
        } else {
            $src = $path;
        }

        if (is_int($index)) $source = ASSETS_URL.'/'.$src.'?v='.(defined('APP_VERSION') ? \Common\Util::urlBase64Encode(APP_VERSION) : 1);
        else $source = $src;

        echo '<link rel="stylesheet" href="'.$source.'" '.($class ? 'class="'.$class.'"' : '').'>'.EOL;
    }

    if (!empty($_inline_styles)) {
        echo '<style>'.EOL.$_inline_styles.EOL.'</style>';
    }

    if (!empty($_inline_scripts)) {
        echo $_inline_scripts;
    }

    ?>


