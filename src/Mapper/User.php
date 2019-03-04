<?php

namespace App\Mapper;

use Fal\Stick\Database\Mapper;
use Fal\Stick\Web\Security\UserInterface;
use Fal\Stick\Web\Security\UserProviderInterface;

class User extends Mapper implements UserProviderInterface, UserInterface
{
    public function findByUsername($username): ?UserInterface
    {
        return $this->first(array('username' => $username))->valid() ? $this : null;
    }

    public function findById($id): ?UserInterface
    {
        return $this->first(array('id' => $id))->valid() ? $this : null;
    }

    public function getId(): string
    {
        return $this['id'] ?? '';
    }

    public function getUsername(): string
    {
        return $this['username'] ?? '';
    }

    public function getPassword(): string
    {
        return $this['password'] ?? '';
    }

    public function getRoles(): array
    {
        return explode(',', $this['roles'] ?? '');
    }

    public function isCredentialsExpired(): bool
    {
        return !$this['active'];
    }
}
