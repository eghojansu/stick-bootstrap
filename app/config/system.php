<?php

use App\Mapper\Config;
use App\Mapper\User;
use Fal\Stick\App;
use Fal\Stick\Cache;
use Fal\Stick\Logger;
use Fal\Stick\Security\Auth;
use Fal\Stick\Security\AuthValidator;
use Fal\Stick\Security\BcryptPasswordEncoder;
use Fal\Stick\Sql\Connection;
use Fal\Stick\Sql\MapperValidator;
use Fal\Stick\Template;
use Fal\Stick\Validation\NativeValidator;
use Fal\Stick\Validation\SimpleValidator;
use Fal\Stick\Validation\Validator;

return [
    'CACHE' => 'auto',
    'CMAPPER' => true,
    'TRACE' => dirname(dirname(__DIR__)),
    'rules' => [
        [Connection::class, function (App $app, Cache $cache, Logger $logger) {
            $option = $app['DB'] + [
                'debug' => $app['DEBUG'] > 0,
                'driver' => 'sqlite',
            ];

            return new Connection($cache, $logger, $option, $app['LOG.LEVEL']);
        }],
        [Template::class, [
            'args' => [
                'dirs' => dirname(__DIR__).'/template/',
            ],
            'boot' => function ($template, $app) {
                $auth = $app->service(Auth::class);

                $info = $app->create(Config::class)->getConfig();
                $info['debug'] = $app['DEBUG'];
                $info['route'] = $app['REQ.ALIAS'];
                $info['user'] = $auth->getUser();
                $info['logged'] = $auth->isLogged();
                $template
                    ->addFunction('path', function (string $alias = null, $args = null, $query = null) use ($app) {
                        return $app['REQ.BASE'].$app->alias($alias ?? $app['REQ.ALIAS'], $args ?: ($alias ? $args : $app['REQ.PARAMS'])).
                            ($query ? '?'.(is_string($query) ? $query : http_build_query($query)) : '');
                    })
                    ->set('app', $info)
                    ->set('asset', $app['REQ.BASE'].'/assets/')
                ;
            },
        ]],
        [Auth::class, [
            'args' => [
                'provider' => User::class,
                'encoder' => BcryptPasswordEncoder::class,
                'options' => [
                    'rules' => [
                        '/dashboard' => 'ROLE_ADMIN',
                    ],
                ],
            ],
        ]],
        [Validator::class, [
            'boot' => function ($validator, $app) {
                $validator->add(new MapperValidator($app->service(Connection::class)));
                $validator->add(new AuthValidator($app->service(Auth::class)));
                $validator->add(new SimpleValidator());
                $validator->add(new NativeValidator());
            },
        ]],
    ],
    'listeners' => [
        [App::EVENT_PREROUTE, function (Auth $auth, App $app) {
            return !$auth->guard();
        }],
        [App::EVENT_ERROR, function (App $app, Template $template, $error, $prior) {
            if ($prior) {
                return;
            }

            if ($app['REQ.AJAX']) {
                return true;
            }

            $app['RES.CONTENT'] = $template->render('error', ['error' => $error]);
            $app->send();
        }],
    ],
];
