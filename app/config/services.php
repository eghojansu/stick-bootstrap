<?php

use App\Mapper\User;
use Fal\Stick\App;
use Fal\Stick\Library\Crud;
use Fal\Stick\Library\Env;
use Fal\Stick\Library\Html\Html;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Security\AuthValidator;
use Fal\Stick\Library\Security\BcryptPasswordEncoder;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Sql\MapperValidator;
use Fal\Stick\Library\Template\Template;
use Fal\Stick\Library\Validation\CommonValidator;
use Fal\Stick\Library\Validation\NativeValidator;
use Fal\Stick\Library\Validation\Validator;

return array(
    array(Connection::class, function (App $app) {
        $options = array(
            'debug' => $app['DEBUG'],
            'dsn' => 'sqlite:'.Env::get('dbpath'),
        );
        $db = new Connection($app, $options);
        $db->setLogLevel($app['THRESHOLD']);

        return $db;
    }),
    array(Template::class, array(
        'args' => array(
            'app' => '%app%',
            'dirs' => dirname(__DIR__).'/template/',
        ),
    )),
    array(Auth::class, array(
        'args' => array(
            'app' => '%app%',
            'provider' => User::class,
            'encoder' => BcryptPasswordEncoder::class,
            'options' => array(
                'rules' => array(
                    '^/dashboard' => 'ROLE_ADMIN',
                ),
                'redirect' => array(
                    'ROLE_ADMIN' => '/dashboard',
                ),
            ),
        ),
    )),
    array(Validator::class, array(
        'boot' => function (App $app, Connection $db, Auth $auth, $validator) {
            $validator->add(new MapperValidator($app, $db));
            $validator->add(new AuthValidator($auth));
            $validator->add(new CommonValidator());
            $validator->add(new NativeValidator());
        },
    )),
    array(Crud::class, array(
        'boot' => function($crud) {
            $crud->views(array(
                'listing' => 'crud/listing.php',
                'view' => 'crud/view.php',
                'create' => 'crud/form.php',
                'update' => 'crud/form.php',
                'delete' => 'crud/delete.php',
                'forbidden' => 'crud/forbidden.php',
            ));
        },
    )),
    array('html', Html::class),
);
