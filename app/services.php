<?php

use App\Mapper\Config;
use Fal\Stick\Fw;
use Fal\Stick\Security\Auth;

return array(
    array('Fal\\Stick\\Sql\\Connection', array(
        'args' => array(
            'fw' => '%fw%',
            'dsn' => '%DB_DSN%',
            'username' => '%DB_USERNAME%',
            'password' => '%DB_PASSWORD%',
        ),
    )),
    array('Fal\\Stick\\Security\\Auth', array(
        'args' => array(
            'fw' => '%fw%',
            'provider' => 'App\\Mapper\\User',
            'encoder' => 'Fal\\Stick\\Security\\BcryptPasswordEncoder',
            'options' => array(
                'redirect' => '/dashboard',
                'logout' => '/logout',
                'rules' => array(
                    '/dashboard' => 'Operator',
                ),
                'roleHierarchy' => array(
                    'Admin' => array('Operator'),
                ),
            ),
        ),
    )),
    array('Fal\\Stick\\Template\\Template', array(
        'args' => array(
            'fw' => '%fw%',
            'paths' => __DIR__.'/template/',
            'globals' => function(Fw $fw, Config $config, Auth $auth) {
                $data =  array(
                    'alerts' => $fw['SESSION']['alerts'],
                    'app' => $config->all(),
                    'user' => $auth->getUser(),
                );
                unset($fw['SESSION']['alerts']);

                return $data;
            },
        ),
        'boot' => function($template) {
            $template
                ->addFunction('alerts', function (array $messages = null) {
                    $str = '';

                    foreach ($messages ?? array() as $type => $message) {
                        if ($message) {
                            $str .= '<div class="alert alert-dismissible alert-'.$type.'">'.
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                                    '<span aria-hidden="true">&times;</span>'.
                                '</button>'.
                                $message.
                                '</div>'
                            ;
                        }
                    }

                    return $str;
                })
            ;
        }
    )),
    array('Fal\\Stick\\Validation\\Validator', array(
        'args' => array(
            'fw' => '%fw%',
            'validators' => array(
                'Fal\\Stick\\Validation\\CommonValidator',
                'Fal\\Stick\\Sql\\MapperValidator',
                'Fal\\Stick\\Security\\AuthValidator',
            ),
        ),
    )),
    array('html', 'Fal\\Stick\\Html\\Html'),
    array('Fal\\Stick\\Util\\Crud', array(
        'boot' => function($crud) {
            $crud
                ->views(array(
                    'listing' => 'crud/listing',
                    'view' => 'crud/view',
                    'create' => 'crud/form',
                    'update' => 'crud/form',
                    'delete' => 'crud/delete',
                    'forbidden' => 'crud/forbidden',
                ))
            ;
        },
    )),
);
