<?php

declare(strict_types=1);

namespace App;

use App\Mapper\Config;
use App\Mapper\User;
use Fal\Stick\App;
use Fal\Stick\Cli;
use Fal\Stick\Security\Auth;
use Fal\Stick\Sql\Connection;

class Setup
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var Cli
     */
    private $cli;

    /**
     * @var bool
     */
    private $verbose;

    /**
     * @var array
     */
    private $scripts;

    /**
     * Class constructor.
     *
     * @param App   $app
     * @param array $scripts
     * @param bool  $verbose
     */
    public function __construct(App $app, array $scripts, bool $verbose = false)
    {
        $this->app = $app;
        $this->scripts = $scripts;
        $this->verbose = $verbose;
        $this->cli = new Cli();
    }

    /**
     * Execute setup.
     *
     * @param string|null &$message
     *
     * @return bool
     */
    public function execute(string &$message = null): bool
    {
        if ($this->verbose) {
            $this->cli->writeln('Starting setup procedure...', 'green', 2);
        }

        $level = ob_get_level();
        $success = false;

        try {
            ob_start();
            $success = $this->doExecute();
            $output = ob_get_clean();
            $message = $success ? 'Setup complete' : 'Setup failed';

            if ($this->verbose) {
                if ($output) {
                    echo $output;
                }

                $success ? $this->cli->success($message) : $this->cli->warning($message);
            }
        } catch (\Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            $message = 'Fatal error: '.$e->getMessage().' in '.$e->getFile().' on line'.$e->getLine();

            if ($this->verbose) {
                $this->cli->danger($message);
            }
        }

        return $success;
    }

    /**
     * Do execute setup logic.
     *
     * @return bool
     */
    private function doExecute(): bool
    {
        $result = $this->setupDatabase();

        return $result;
    }

    /**
     * Perform database setup.
     *
     * @return bool
     */
    private function setupDatabase(): bool
    {
        $conn = $this->app->service(Connection::class);

        foreach ($this->scripts as $script) {
            $content = file_get_contents($script);

            if ($content) {
                $conn->pdo()->exec($content);
            }
        }

        $config = $this->app->create(Config::class);

        foreach (Config::defaultConfig() as $item) {
            if ($config->reset()->find($item['name'])->dry()) {
                $config->fromArray($item)->insert();
            }
        }

        $username = 'admin123';
        $user = $this->app->create(User::class);

        if ($user->findByUsername($username)->dry()) {
            $user->on('insert', function ($user) {
                $user['profile']->fromArray(['fullname' => 'Administrator'])->insert();
            })->fromArray([
                'username' => $username,
                'password' => $this->app->service(Auth::class)->getEncoder()->hash($username),
                'roles' => 'ROLE_ADMIN',
            ])->insert();
        }

        return true;
    }
}
