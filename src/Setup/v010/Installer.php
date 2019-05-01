<?php

namespace App\Setup\v010;

use App\Setup\SetupInterface;
use App\Setup\SqlExecutor;
use Fal\Stick\Form\Form;
use Fal\Stick\Fw;

class Installer implements SetupInterface
{
    private $fw;

    public function getVersion(): string
    {
        return 'v0.1.0';
    }

    public function prepare(Fw $fw, Form $form): void
    {
        $this->fw = $fw;
    }

    public function install(SqlExecutor $exec): array
    {
        $exec(file_get_contents(__DIR__.'/01-create.sql'));
        $this->insertDefaultUser();

        return array();
    }

    private function insertDefaultUser()
    {
        $user = $this->fw->mapper('User');
        $user->fromArray(array(
            'username' => 'myadmin',
            'password' => $this->fw->auth->encoder->hash('admin123'),
            'fullname' => 'Administrator',
            'roles' => 'ROLE_ADMIN',
            'active' => 1,
        ));
        $user->save();
    }
}
