<?php

declare(strict_types=1);

namespace App\Test\Controller;

use App\Test\Tools\TestCase;

class DashboardControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->login('foobar');
    }

    public function testDashboard()
    {
        $this
            ->visit('dashboard')
            ->assertSuccess()
            ->assertAtPath('/dashboard')
            ->assertResponseContains('Welcome to dashboard')
            ->clearRequest()
            ->logout()
            ->visit('dashboard')
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/login')
        ;
    }

    public function testProfile()
    {
        $this
            ->visit('profile')
            ->assertSuccess()
            ->assertAtPath('/dashboard/profile')
            ->assertInputExists('username')
            ->assertInputExists('password')
            ->assertInputExists('new_password')
            ->assertInputExists('fullname')
        ;
    }

    public function testProfileUpdate()
    {
        $this
            ->post('profile', ['fullname' => 'change fullname', 'password' => 'foobar', 'username' => 'foobar'])
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/profile')
        ;

        $user = $this->getUser();

        $this->assertEquals('foobar', $user->get('username'));
        $this->assertEquals('change fullname', $user->get('profile')->get('fullname'));
    }

    public function profileUpdateErrorProvider()
    {
        $notblank = 'This value should not be blank.';
        $toshort = 'This value is too short. It should have 6 characters or more.';

        return [
            [
                [],
                [
                    'username' => [$notblank],
                    'fullname' => [$notblank],
                    'password' => [$notblank],
                ],
            ],
            [
                ['username' => 'foo', 'new_password' => 'foo', 'password' => 'foo'],
                [
                    'username' => [$toshort],
                    'fullname' => [$notblank],
                    'new_password' => [$toshort],
                    'password' => ['This value should be equal to current user password.'],
                ],
            ],
            [
                ['username' => 'barbaz', 'fullname' => 'foobar', 'password' => 'foobar'],
                [
                    'username' => ['This value is already used.'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider profileUpdateErrorProvider
     */
    public function testProfileUpdateError($data, $error)
    {
        $this
            ->post('profile', $data)
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/profile')
            ->assertHiveEquals('SESSION.error', $error)
        ;
    }
}
