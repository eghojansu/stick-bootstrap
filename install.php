<?php

use Fal\Stick\Web\Kernel;

if ('cli' !== PHP_SAPI) {
    die('Please execute from your console!');
}

$start = microtime(true);
$config = require __DIR__.'/config/bootstrap.php';
$kernel = new Kernel($config['env'], $config['debug'], $config['config']);
$kernel->config($config['file'][$config['env']], true);

// clear cache
$kernel->getContainer()->get('cache')->reset();

// handle schema
$db = $kernel->getContainer()->get('db_driver');
$execute = function ($schema) use ($db) {
    $schemas = array(
        'create' => __DIR__.'/db/010-create.sql',
        'drop' => __DIR__.'/db/010-drop.sql',
    );

    echo 'Executing '.$schema.' schema...';

    try {
        $pdo = $db->pdo();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec(file_get_contents($schemas[$schema]));
        echo 'done';
        echo PHP_EOL;
    } catch (\Throwable $e) {
        echo 'error! ('.$e->getMessage().')';
        echo PHP_EOL;
    }
};

if ($db->exists('user')) {
    echo 'Execute tables drop? (Y/n) ';
    $answer = trim(fgets(STDIN));

    if ($answer && ('y' !== $answer[0] || 'Y' !== $answer[0])) {
        echo PHP_EOL;
        echo 'Canceled';
        echo PHP_EOL;

        die;
    }

    $execute('drop');
}

$execute('create');

// insert user
echo 'Inserting default user...';
$auth = $kernel->getContainer()->get('auth');
$user = $kernel->getContainer()->get('App\\Mapper\\User');
$users = array(
    array(
        'fullname' => 'Administrator',
        'username' => 'admin',
        'password' => $auth->getEncoder()->hash('admin123'),
        'roles' => 'Admin',
    ),
);

foreach ($users as $data) {
    $user->reset()->fromArray($data)->save();
}
echo 'done';
echo PHP_EOL;

echo 'Install complete in '.(microtime(true) - $start).' seconds';
echo PHP_EOL;
