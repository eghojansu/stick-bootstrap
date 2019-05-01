<?php

namespace App\Setup;

class SqlExecutor
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke($sql)
    {
        $this->pdo->exec($sql);
        $error = $this->pdo->errorInfo();

        if ('00000' !== $error[0]) {
            throw new \LogicException(sprintf('[%s - %s] %s.', ...$error));
        }
    }
}
