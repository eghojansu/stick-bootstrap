<?php

declare(strict_types=1);

namespace App\Test\Controller\Master;

use App\Test\Tools\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->login('foobar');
    }

    public function testIndex()
    {
        $this
            ->visit('user_index')
            ->assertSuccess()
            ->assertAtPath('/dashboard/user')
            ->assertResponseNotContains('foobar')
            ->assertResponseContains('barbaz')
            ->assertResponseContains('bazqux')
        ;
    }

    public function testCreate()
    {
        $this
            ->visit('user_create')
            ->assertSuccess()
            ->assertAtPath('/dashboard/user/create')
            ->assertInputExists('username')
            ->assertInputExists('fullname')
            ->assertInputExists('password')
        ;
    }

    public function testCreateCommit()
    {
        $this
            ->post('user_create', ['username' => 'blehbleh', 'password' => 'blehbleh', 'fullname' => 'bableh'])
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/user')
        ;

        $user = $this->getMapper('user')->find(4);

        $this->assertTrue($user->valid());
        $this->assertEquals('blehbleh', $user->get('username'));
        $this->assertEquals('bableh', $user->get('profile')->get('fullname'));
    }

    public function createCommitErrorProvider()
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
                ['username' => 'foo', 'password' => 'foo'],
                [
                    'username' => [$toshort],
                    'fullname' => [$notblank],
                    'password' => [$toshort],
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
     * @dataProvider createCommitErrorProvider
     */
    public function testCreateCommitError($data, $error)
    {
        $this
            ->post('user_create', $data)
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/user/create')
            ->assertHiveEquals('SESSION.error', $error)
        ;
    }

    public function testEdit()
    {
        $this
            ->visit('/dashboard/user/edit/2')
            ->assertSuccess()
            ->assertAtRoute('user_edit')
            ->assertInputExists('username')
            ->assertInputExists('fullname')
            ->assertInputExists('password')
            ->assertResponseContains('barbaz')
        ;
    }

    public function testEditCommit()
    {
        $this
            ->post('/dashboard/user/edit/2', ['username' => 'barbaz', 'fullname' => 'change'])
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/user')
        ;

        $user = $this->getMapper('user')->find(2);

        $this->assertTrue($user->valid());
        $this->assertEquals('barbaz', $user->get('username'));
        $this->assertEquals('change', $user->get('profile')->get('fullname'));
    }

    public function editCommitErrorProvider()
    {
        $notblank = 'This value should not be blank.';
        $toshort = 'This value is too short. It should have 6 characters or more.';

        return [
            [
                2,
                [],
                [
                    'username' => [$notblank],
                    'fullname' => [$notblank],
                ],
            ],
            [
                2,
                ['username' => 'foo', 'password' => 'foo'],
                [
                    'username' => [$toshort],
                    'fullname' => [$notblank],
                    'password' => [$toshort],
                ],
            ],
            [
                3,
                ['username' => 'barbaz', 'fullname' => 'foobar', 'password' => 'foobar'],
                [
                    'username' => ['This value is already used.'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider editCommitErrorProvider
     */
    public function testEditCommitError($id, $data, $error)
    {
        $this
            ->post('/dashboard/user/edit/'.$id, $data)
            ->assertSuccess()
            ->assertRedirected()
            ->assertRedirectedTo('/dashboard/user/edit/'.$id)
            ->assertHiveEquals('SESSION.error', $error)
        ;
    }

    public function testDelete()
    {
        $this
            ->setRequest(['mode' => 'ajax'])
            ->delete('/dashboard/user/delete/4')
            ->assertNotSuccess()
            ->assertHiveContains('ERROR.text', 'Record of user not found')
            ->clearRequest()
            ->setRequest(['mode' => 'ajax'])
            ->delete('/dashboard/user/delete/2')
            ->assertSuccess()
            ->assertResponseContains('User has been deleted')
        ;
    }
}
