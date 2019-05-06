<?php

namespace App\Setup\Setup;

use Fal\Stick\Fw;

class SqliteSetup extends MysqlSetup
{
    public function __construct(Fw $fw)
    {
        $this->initial = self::overrideInitial($fw, $this->commitPrefix, array(
            'db_path'  => $fw->TEMP.'app.db',
        ));
        $this->fw = $fw;
        $this->form = $fw->form('install', $this->initial);
    }

    protected function requestDBForm()
    {
        $this->form
            ->set('db_path', 'text', array(
                'label' => 'DB path',
                'attr' => array(
                    'placeholder' => 'Database path',
                ),
                'constraints' => 'trim|required',
            ))
        ;
    }

    protected function connect()
    {
        try {
            $createDb = isset($this->commit['DB']);

            if ($createDb) {
                $this->fw['DB'] = $this->commit['DB'];
            }

            $db = $this->fw['DB'];

            if ($this->installFromBeginning()) {
                $this->fw->delete($db['path']);
            }

            $dsn = 'sqlite:'.$db['path'];
            $pdo = new \PDO($dsn);
        } catch (\PDOException $e) {
            throw new \LogicException('Invalid database configuration ('.$e->getMessage().').');
        }
    }
}
