<?php

declare(strict_types=1);

/**
 * This file is part of the eghojansu/stick-bootstrap library.
 *
 * (c) Eko Kurniawan <ekokurniawanbs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Test\Tools;

use App\Mapper\Config;
use App\Mapper\User;
use App\Setup;
use Fal\Stick\App;
use Fal\Stick\Security\Auth;
use Fal\Stick\Sql\Connection;
use Fal\Stick\Sql\Mapper;
use PHPUnit\Framework\TestCase as TestCaseBase;

class TestCase extends TestCaseBase
{
    /**
     * @var App
     */
    protected $app;

    /**
     * Current request parameters.
     *
     * @var array
     */
    protected $request = [];

    /**
     * Reports an error if hive value is not equal to expected value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return TestCase
     */
    protected function assertHiveEquals(string $key, $value): TestCase
    {
        $this->assertEquals($value, $this->app->get($key), 'Hive not equal.');

        return $this;
    }

    /**
     * This is the inverse of assertHiveEquals.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return TestCase
     */
    protected function assertHiveNotEquals(string $key, $value): TestCase
    {
        $this->assertNotEquals($value, $this->app->get($key), 'Hive equal.');

        return $this;
    }

    /**
     * Reports an error if hive value not contains expected value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return TestCase
     */
    protected function assertHiveContains(string $key, $value): TestCase
    {
        $this->assertContains($value, $this->app->get($key), 'Hive not contains.');

        return $this;
    }

    /**
     * This is the inverse of assertHiveContains.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return TestCase
     */
    protected function assertHiveNotContains(string $key, $value): TestCase
    {
        $this->assertNotContains($value, $this->app->get($key), 'Hive contains.');

        return $this;
    }

    /**
     * Reports an error if current response is not redirected.
     *
     * @return TestCase
     */
    protected function assertRedirected(): TestCase
    {
        $this->assertContains('Location', array_keys($this->app->get('RES.HEADERS')), 'Not redirected.');

        return $this;
    }

    /**
     * This is the inverse of assertRedirected.
     *
     * @return TestCase
     */
    protected function assertNotRedirected(): TestCase
    {
        $this->assertNotContains('Location', array_keys($this->app->get('RES.HEADERS')), 'Redirected.');

        return $this;
    }

    /**
     * Reports an error if current response is not redirected to expected path.
     *
     * @param string $path
     * @param bool   $self
     *
     * @return TestCase
     */
    protected function assertRedirectedTo(string $path, bool $self = true): TestCase
    {
        $this->assertEquals($self ? $this->app->url($path) : $path, $this->app->get('RES.HEADERS.Location'), 'Not redirected to given path');

        return $this;
    }

    /**
     * This is the inverse of assertRedirectedTo.
     *
     * @param string $path
     * @param bool   $self
     *
     * @return TestCase
     */
    protected function assertNotRedirectedTo(string $path, bool $self = true): TestCase
    {
        $this->assertNotEquals($self ? $this->app->url($path) : $path, $this->app->get('RES.HEADERS.Location'), 'Redirected to given path');

        return $this;
    }

    /**
     * Reports an error if current path is not equals to expected path.
     *
     * @param string $path
     *
     * @return TestCase
     */
    protected function assertAtPath(string $path): TestCase
    {
        $this->assertEquals($path, $this->app->get('REQ.PATH'), 'Not at path.');

        return $this;
    }

    /**
     * This is the inverse of assertAtPath.
     *
     * @param string $path
     *
     * @return TestCase
     */
    protected function assertNotAtPath(string $path): TestCase
    {
        $this->assertNotEquals($path, $this->app->get('REQ.PATH'), 'At path.');

        return $this;
    }

    /**
     * Reports an error if current route is not equals to expected route.
     *
     * @param string $route
     *
     * @return TestCase
     */
    protected function assertAtRoute(string $route): TestCase
    {
        $this->assertEquals($route, $this->app->get('REQ.ALIAS'), 'Not at route.');

        return $this;
    }

    /**
     * This is the inverse of assertAtRoute.
     *
     * @param string $route
     *
     * @return TestCase
     */
    protected function assertNotAtRoute(string $route): TestCase
    {
        $this->assertNotEquals($route, $this->app->get('REQ.ALIAS'), 'At route.');

        return $this;
    }

    /**
     * Reports an error if current response not contains expected text.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertResponseContains(string $text): TestCase
    {
        $this->assertContains($text, $this->app->get('RES.CONTENT'), 'Response not contains expected text.');

        return $this;
    }

    /**
     * This is the inverse of assertResponseContains.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertResponseNotContains(string $text): TestCase
    {
        $this->assertNotContains($text, $this->app->get('RES.CONTENT'), 'Response contains expected text.');

        return $this;
    }

    /**
     * Reports an error if current response is not equals to expected text.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertResponseEquals(string $text): TestCase
    {
        $this->assertEquals($text, $this->app->get('RES.CONTENT'), 'Response is not equals to expected text.');

        return $this;
    }

    /**
     * This is the inverse of assertResponseEquals.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertResponseNotEquals(string $text): TestCase
    {
        $this->assertNotEquals($text, $this->app->get('RES.CONTENT'), 'Response is equals to expected text.');

        return $this;
    }

    /**
     * Reports an error if current response headers not contains expected value.
     *
     * @param mixed $value
     *
     * @return TestCase
     */
    protected function assertHeadersContains($value): TestCase
    {
        $this->assertContains($value, $this->app->get('RES.HEADERS'), 'Response headers not contains expected value.');

        return $this;
    }

    /**
     * This is the inverse of assertHeadersContains.
     *
     * @param mixed $value
     *
     * @return TestCase
     */
    protected function assertHeadersNotContains($value): TestCase
    {
        $this->assertNotContains($value, $this->app->get('RES.HEADERS'), 'Response headers contains expected value.');

        return $this;
    }

    /**
     * Reports an error if current response headers contains expected value.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertHeadersContainsKey(string $text): TestCase
    {
        $this->assertContains($text, array_keys($this->app->get('RES.HEADERS')), 'Response headers contains expected key.');

        return $this;
    }

    /**
     * This is the inverse of assertHeadersKeyContains.
     *
     * @param string $text
     *
     * @return TestCase
     */
    protected function assertHeadersNotContainsKey(string $text): TestCase
    {
        $this->assertNotContains($text, array_keys($this->app->get('RES.HEADERS')), 'Response headers contains expected key.');

        return $this;
    }

    /**
     * Reports an error if current request has error.
     *
     * @return TestCase
     */
    protected function assertSuccess(): TestCase
    {
        $this->assertEmpty($this->app->get('ERROR'), 'Request has error.');

        return $this;
    }

    /**
     * This is the inverse of assertSuccess.
     *
     * @return TestCase
     */
    protected function assertNotSuccess(): TestCase
    {
        $this->assertnotEmpty($this->app->get('ERROR'), 'Request has no error.');

        return $this;
    }

    /**
     * Reports error if response content contains named input.
     *
     * @param string $name
     * @param string $tag
     *
     * @return TestCase
     */
    protected function assertInputExists(string $name, string $tag = 'input'): TestCase
    {
        $this->assertRegExp('/<'.$tag.'.+name=[\'"]'.preg_quote($name).'[\'"].+>/', $this->app->get('RES.CONTENT'), 'Response has not named input.');

        return $this;
    }

    /**
     * This is the inverse of assertInputExists.
     *
     * @param string $name
     * @param string $tag
     *
     * @return TestCase
     */
    protected function assertInputNotExists(string $name, string $tag = 'input'): TestCase
    {
        $this->assertNotRegExp('/<'.$tag.'.+name=[\'"]'.preg_quote($name).'[\'"].+>/', $this->app->get('RES.CONTENT'), 'Response has named input.');

        return $this;
    }

    /**
     * Set user.
     *
     * @param string $username
     *
     * @return TestCase
     */
    protected function login(string $username): TestCase
    {
        $auth = $this->app->service(Auth::class);

        $auth->login($this->app->create(User::class)->findByUsername($username));

        return $this;
    }

    /**
     * Clear user.
     *
     * @return TestCase
     */
    protected function logout(): TestCase
    {
        $this->app->service(Auth::class)->logout();

        return $this;
    }

    /**
     * Prepare the app instance.
     */
    public function setUp()
    {
        $context = Context::instance()->context;
        $db = $context['temp'].'app.db';
        $sp = $context['scriptPath'];

        $this->app = $context['app'];
        $this->app->mset([
            'TEMP' => $context['temp'],
            'DB' => ['location' => ':memory:'],
        ]);

        $pdo = $this->app->service(Connection::class)->pdo();
        $pdo->exec(file_get_contents($sp.'700-drop.sql'));
        $pdo->exec(file_get_contents($sp.'100-create.sql'));

        $users = [
            ['foobar', 'ROLE_ADMIN', 1],
            ['barbaz', 'ROLE_ADMIN', 1],
            ['bazqux', 'ROLE_ADMIN', 1],
        ];
        $user = $this->app->create(User::class);
        $encoder = $this->app->service(Auth::class)->getEncoder();

        foreach ($users as $item) {
            $user->reset()->one('insert', function ($user) use ($item) {
                $user['profile']->set('fullname', $item[0])->insert();
            })->fromArray([
                'username' => $item[0],
                'password' => $encoder->hash($item[0]),
                'roles' => $item[1],
                'active' => $item[2],
            ])->insert();
        }

        $config = $this->app->create(Config::class);

        foreach (Config::defaultConfig() as $item) {
            $config->reset()->fromArray($item)->insert();
        }
    }

    /**
     * Reset globals.
     */
    public function tearDown()
    {
        $this->app->mclear(explode('|', App::GLOBALS))->service(Auth::class)->logout();
    }

    /**
     * Perform request.
     *
     * @return TestCase
     */
    protected function doRequest(): TestCase
    {
        $args = [
            trim(($this->request['method'] ?? '').' '.($this->request['path'] ?? '').' '.($this->request['mode'] ?? '')),
            $this->request['data'] ?? null,
            $this->request['headers'] ?? null,
            $this->request['body'] ?? null,
        ];
        $quiet = $this->app->get('QUIET');

        $this->app->set('QUIET', true)->mock(...$args)->set('QUIET', $quiet);

        return $this;
    }

    /**
     * Delete request.
     *
     * @param string $path
     *
     * @return TestCase
     */
    protected function delete(string $path): TestCase
    {
        $this->request['path'] = $path;
        $this->request['method'] = 'DELETE';

        return $this->doRequest();
    }

    /**
     * Post request.
     *
     * @param string $path
     * @param array  $data
     *
     * @return TestCase
     */
    protected function post(string $path, array $data = null): TestCase
    {
        $this->request['path'] = $path;
        $this->request['data'] = $data;
        $this->request['method'] = 'POST';

        return $this->doRequest();
    }

    /**
     * Get request.
     *
     * @param string $path
     * @param array  $queries
     *
     * @return TestCase
     */
    protected function visit(string $path, array $queries = null): TestCase
    {
        $this->request['path'] = $path;
        $this->request['data'] = $queries;
        $this->request['method'] = 'GET';

        return $this->doRequest();
    }

    /**
     * Set request parameters.
     *
     * @param array $request
     *
     * @return TestCase
     */
    protected function setRequest(array $request): TestCase
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Reset request.
     *
     * @return TestCase
     */
    protected function clearRequest(): TestCase
    {
        $this->request = [];

        return $this;
    }

    /**
     * Get current user.
     *
     * @return User
     */
    protected function getUser(): User
    {
        return $this->app->service(Auth::class)->getUser();
    }

    /**
     * Get mapper instance.
     *
     * @return Mapper
     */
    protected function getMapper(string $id): Mapper
    {
        $map = [
            'user' => User::class,
            'config' => Config::class,
        ];

        if (!isset($map[$id])) {
            throw new \LogicException('Invalid mapper request.');
        }

        return $this->app->create($map[$id]);
    }

    /**
     * Dump key content.
     *
     * @param string $key
     * @param bool   $halt
     *
     * @return TestCase
     */
    protected function dump(string $key, bool $halt = false): TestCase
    {
        var_dump($this->app->get($key));

        if ($halt) {
            die;
        }

        return $this;
    }
}
