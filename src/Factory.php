<?php

namespace App;

use Fal\Stick\Db\Pdo\Db;
use Fal\Stick\Db\Pdo\Driver\MysqlDriver;
use Fal\Stick\Db\Pdo\Driver\SqliteDriver;
use Fal\Stick\Db\Pdo\Mapper;
use Fal\Stick\Form\Form;
use Fal\Stick\Form\FormBuilder\Twbs3FormBuilder;
use Fal\Stick\Fw;
use Fal\Stick\Html\MenuList;
use Fal\Stick\Html\PaginationList;
use Fal\Stick\Security\Auth;
use Fal\Stick\Security\BcryptPasswordEncoder;
use Fal\Stick\Template\Environment;
use Fal\Stick\Util\Crud;
use Fal\Stick\Util\ValueStore;
use Fal\Stick\Validation\Rules\LaravelRule;
use Fal\Stick\Validation\Validator;

class Factory
{
    public static function mapper(Fw $fw, $table)
    {
        if (class_exists($mapper = 'App\\Mapper\\'.$table)) {
            return new $mapper($fw->db);
        }

        return new Mapper($fw->db, $table);
    }

    public static function form(Fw $fw, $name, array $data = null, array $options = null)
    {
        if (class_exists($form = 'App\\Form\\'.$name.'Form')) {
            return new $form($fw, $fw->validator, $fw->formBuilder, $data, $options);
        }

        return new Form($fw, $fw->validator, $fw->formBuilder, $data, $options, $name);
    }

    public static function store(Fw $fw)
    {
        return new ValueStore($fw->config_dir.'/app.json', $fw->TEMP.'app.json');
    }

    public static function formBuilder(Fw $fw)
    {
        return new Twbs3FormBuilder($fw);
    }

    public static function template(Fw $fw)
    {
        return (new Environment($fw, $fw->template_dir, null, null, $fw->template_reload))
            ->extend('alerts', 'App\\Tag::alerts');
    }

    public static function validator(Fw $fw)
    {
        $validator = new Validator($fw);
        $validator->add(new LaravelRule());

        return $validator;
    }

    public static function dbSqlite(Fw $fw)
    {
        $db = $fw->DB;
        $dsn = 'sqlite:'.$db['path'];

        return new Db($fw, new SqliteDriver(), $dsn);
    }

    public static function dbMysql(Fw $fw)
    {
        $db = $fw->DB;
        $dsn = 'mysql:host='.$db['host'].';port='.$db['port'].';dbname='.$db['dbname'];

        return new Db($fw, new MysqlDriver(), $dsn, $db['username'], $db['password']);
    }

    public static function auth(Fw $fw)
    {
        return new Auth($fw, self::mapper($fw, 'User'), new BcryptPasswordEncoder(), array(
            'rules' => array(
                '^/dashboard' => array(
                    'roles' => 'ROLE_USER',
                    'login' => '/login',
                    'home' => '/dashboard',
                ),
            ),
            'role_hierarchy' => array(
                'ROLE_ADMIN' => 'ROLE_USER',
            ),
        ));
    }

    public static function user(Fw $fw)
    {
        return $fw->auth->getUser();
    }

    public static function crud(Fw $fw)
    {
        return (new Crud($fw, $fw->template, $fw->auth))
            ->views(array(
                'view' => 'crud.view',
                'listing' => 'crud.listing',
                'create' => 'crud.form',
                'update' => 'crud.form',
                'delete' => 'crud.delete',
                'forbidden' => 'crud.forbidden',
            ))
            ->createNew(true)
            ->appendQuery(true)
        ;
    }

    public static function menu(Fw $fw)
    {
        return new MenuList($fw, $fw->auth);
    }

    public static function pagination(Fw $fw)
    {
        return new PaginationList($fw);
    }
}
