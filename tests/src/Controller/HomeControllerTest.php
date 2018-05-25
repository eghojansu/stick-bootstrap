<?php

declare(strict_types=1);

namespace App\Test\Controller;

use App\Test\Tools\TestCase;
use Fal\Stick\Security\Auth;

class HomeControllerTest extends TestCase
{
    public function testHome()
    {
        $this
            ->visit('home')
            ->assertSuccess()
            ->assertAtPath('/')
            ->assertResponseContains('Welcome to Stick-Bootstrap App.')
        ;
    }

    public function testLogin()
    {
        $this
            ->visit('login')
            ->assertSuccess()
            ->assertAtPath('/login')
            ->assertInputExists('username')
            ->assertInputExists('password')
        ;
    }

    public function testLoginCheck()
    {
        $this
            ->post('login', ['username' => 'foobar', 'password' => 'foobar'])
            ->assertSuccess()
            ->assertAtPath('/login')
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard')
        ;

        $this->assertEquals('foobar', $this->getUser()->get('profile')->get('fullname'));
    }

    public function loginCheckInvalidProvider()
    {
        return [
            ['foo', 'bar'],
            ['foobar', 'bar'],
            ['foo', 'foobar'],
        ];
    }

    /**
     * @dataProvider loginCheckInvalidProvider
     */
    public function testLoginCheckInvalid($username, $password)
    {
        $this
            ->post('login', ['username' => $username, 'password' => $password])
            ->assertSuccess()
            ->assertRedirected()
            ->assertHiveEquals('SESSION.attempt.message', Auth::ERROR_CREDENTIAL_INVALID)
        ;
    }

    public function testLogout()
    {
        $this
            ->visit('logout')
            ->assertSuccess()
            ->assertAtPath('/logout')
            ->assertRedirected()
            ->assertRedirectedTo('/')
        ;
    }
}
