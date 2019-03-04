<?php

use Fal\Stick\Web\Kernel;

if ('cli' !== PHP_SAPI) {
    die('Please execute from your console!');
}

$config = require __DIR__.'/config/bootstrap.php';
$kernel = new Kernel($config['env'], $config['debug'], $config['config']);
$kernel->config($config['file'][$config['env']], true);

// clear cache
$kernel->getContainer()->get('cache')->reset();

// handle schema
$db = $kernel->getContainer()->get('db_driver');

if ($db->exists('user')) {
    echo 'Execute tables drop? (Y/n) ';
    $answer = trim(fgets(STDIN));

    if ($answer && ('y' !== $answer[0] || 'Y' !== $answer[0])) {
        echo PHP_EOL;
        echo 'Canceled';
        echo PHP_EOL;

        die;
    }

    executeSchema($db, 'drop');
}

executeSchema($db, 'create');

// insert user
$auth = $kernel->getContainer()->get('auth');
$user = $kernel->getContainer()->get('App\\Mapper\\User');
$users = array(
    array(
        'fullname' => 'Administrator',
        'username' => 'adminku',
        'password' => $auth->getEncoder()->hash('admin123'),
        'roles' => 'Admin',
    ),
);

foreach ($users as $data) {
    $user->reset()->fromArray($data)->save();
}

function executeSchema($db, $schema) {
    $schemas = array(
        'create' => __DIR__.'/db/010-create.sql',
        'drop' => __DIR__.'/db/010-drop.sql',
    );
    $pdo = $db->pdo();

    echo 'Executing '.$schema.' schema...';
    echo PHP_EOL;
    echo '  Result: ';
    var_export($pdo->exec($content = file_get_contents($schemas[$schema])));
    echo PHP_EOL;

    if ('00000' !== $pdo->errorCode()) {
        foreach ($pdo->errorInfo() as $key => $value) {
            echo '  '.$key.': '.$value;
            echo PHP_EOL;
        }
    }

    echo 'done';
    echo PHP_EOL;
}
