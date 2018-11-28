<?php

namespace App\Mapper;

use Fal\Stick\Security\UserInterface;
use Fal\Stick\Security\UserProviderInterface;
use Fal\Stick\Sql\Mapper;

class User extends Mapper implements UserProviderInterface, UserInterface
{
    public function findByUsername($username): ?UserInterface
    {
        return $this->findOneByUsername($username);
    }

    public function findById($id): ?UserInterface
    {
        return $this->find($id);
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
