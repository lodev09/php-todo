<?php

require_once 'init.php';

$_title = 'Database';
include_once APP_PATH.'/includes/_head.php';

?>

<body>
    <div class="wrapper">
        <header><?= APP_TITLE ?></header>
        <small class="text-muted">Version <?= APP_VERSION ?></small>

        <div>
            <p>The page you're trying to open requires your database configured. <br>Please review the following and update your <code>.env</code> file accordingly</p>
            <p>For more information about installing <?= APP_TITLE ?>, please follow the <strong>README.md</strong>.</p>
        </div>

        <?php if (!empty($_db_error)) : ?>
            <div class="mb-3">
                <samp class="text-danger"><?= escape($_db_error) ?></samp>
            </div>
        <?php endif ?>

        <?php if (__DEV__): ?>
            <h4>
                Your credentials
                <small class="text-muted">(.env)</small>
            </h4>

            <?php

            $command = 'DB_HOST=<span class="text-warning">'.DB_PATH.'</span>'.EOL;
            $command .= EOL.'<em>#...</em>';

            ?>

            <div><?php plog($command) ?></div>

        <?php endif ?>
    </div>
    <!-- / Content -->

    <?php include_once APP_PATH.'/includes/_js.php'; ?>

</body>
</html>
