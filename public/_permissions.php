<?php

require_once 'init.php';

$_title = 'Permissions';
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div>
            <p>Please make sure that the following directories are writable by PHP.<br>If you're running on <span class="text-warning">Windows</span>, make sure you have rights on the root folder.</p>
            <p>For more information about installing <?= APP_TITLE ?>, please follow the <strong>README.md</strong>.</p>
        </div>

        <?php if (!empty($_db_error)) : ?>
            <div class="mb-3">
                <samp class="text-danger"><?= escape($_db_error) ?></samp>
            </div>
        <?php endif ?>

        <?php if (__DEV__): ?>
            <h4>
                UNIX Systems
                <small class="text-muted">(Linux, MacOS)</small>
            </h4>

            <?php

            $root_dir = file_exists(ROOT_PATH.'/composer.json') ? ROOT_PATH : dirname(ROOT_PATH);
            $command = 'chmod 775 <span class="text-warning">'.$root_dir.'</span>';

            ?>

            <div><?php plog($command) ?></div>

        <?php endif ?>
    </div>
    <!-- / Content -->

    <?php include_once APP_PATH.'/includes/_js.php'; ?>

</body>
</html>
