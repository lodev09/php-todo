<?php

require_once 'init.php';

$_title = 'Installation';
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div>
            <p>This APP requires <span class="text-warning">Composer</span> dependency manager.<br>Please follow instructions below to get started.</p>
            <p>For more information about installing <?= APP_TITLE ?>, please follow the <strong>README.md</strong>.</p>
        </div>

        <?php if (!empty($_db_error)) : ?>
            <div class="mb-3">
                <samp class="text-danger"><?= escape($_db_error) ?></samp>
            </div>
        <?php endif ?>

        <?php if (__DEV__): ?>
            <h4>
                Installation
                <small class="text-muted">(composer)</small>
            </h4>

            <?php

            $root_dir = file_exists(ROOT_PATH.'/composer.json') ? ROOT_PATH : dirname(ROOT_PATH);
            $command = 'cd '.$root_dir.EOL;
            $command .= 'composer install';

            ?>

            <ol class="pl-4">
                <li>Download <a href="https://getcomposer.org/download/" target="_blank">Composer</a>.</li>
                <li>
                    Run the following commands:
                    <div><?php plog($command) ?></div>
                </li>
            </ol>


        <?php endif ?>
    </div>
    <!-- / Content -->

    <?php include_once APP_PATH.'/includes/_js.php'; ?>

</body>
</html>
