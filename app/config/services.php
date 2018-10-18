<?php

use Fal\Stick\Fw;
use Fal\Stick\Library\Crud\Crud;
use Fal\Stick\Library\Html\Html;
use Fal\Stick\Library\Security\Auth;
use Fal\Stick\Library\Security\AuthValidator;
use Fal\Stick\Library\Sql\Connection;
use Fal\Stick\Library\Sql\MapperValidator;
use Fal\Stick\Library\Template\Template;
use Fal\Stick\Library\Validation\CommonValidator;
use Fal\Stick\Library\Validation\Validator;

return array(
    array(Connection::class, function(Fw $fw) {
        return new Connection($fw, $fw->DB_OPTIONS);
    }),
    array(Template::class, array(
        'args' => array(
            'fw' => '%fw%',
            'dirs' => array(dirname(__DIR__).'/template/'),
        ),
    )),
    array(Auth::class, array(
        'args' => array(
            'fw' => '%fw%',
            'provider' => 'App\\Mapper\\User',
            'encoder' => 'Fal\\Stick\\Library\\Security\\BcryptPasswordEncoder',
            'options' => array(
                'login' => '/login',
                'logout' => '/logout',
                'redirect' => '/dashboard',
                'rules' => array(
                    '/dashboard' => 'Operator',
                ),
                'roleHierarchy' => array(
                    'Admin' => array('Operator'),
                ),
            ),
        ),
    )),
    array(Validator::class, array(
        'boot' => function(CommonValidator $common, MapperValidator $mapper, AuthValidator $auth, $validator) {
            $validator->add($common, $mapper, $auth);
        },
    )),
    array(Crud::class, array(
        'boot' => function($crud) {
            $crud
                ->views(array(
                    'listing' => 'crud/listing.php',
                    'view' => 'crud/view.php',
                    'create' => 'crud/form.php',
                    'update' => 'crud/form.php',
                    'delete' => 'crud/delete.php',
                    'forbidden' => 'crud/forbidden.php',
                ))
            ;
        },
    )),
    array('html', Html::class),
);
