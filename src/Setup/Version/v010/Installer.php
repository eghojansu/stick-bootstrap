<?php

namespace App\Setup\Version\v010;

use App\Setup\SetupInterface;
use App\Setup\VersionSetupInterface;
use Fal\Stick\Fw;

class Installer implements VersionSetupInterface
{
    public function getVersion(): string
    {
        return 'v0.1.0';
    }

    public function prepare(Fw $fw, SetupInterface $setup)
    {
    }

    public function install(Fw $fw, SetupInterface $setup)
    {
        $setup->execSql(file_get_contents(__DIR__.'/01-create.sql'));

        self::insertDefaultUser($fw);
    }

    private static function insertDefaultUser(Fw $fw)
    {
        $fw->mapper('User')->fromArray(array(
            'username' => 'myadmin',
            'password' => $fw->auth->encoder->hash('admin123'),
            'fullname' => 'Administrator',
            'roles' => 'ROLE_ADMIN',
            'active' => 1,
        ))->save();
    }
}
