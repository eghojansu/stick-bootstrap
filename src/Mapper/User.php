<?php

namespace App\Mapper;

use Fal\Stick\Db\Pdo\Mapper;
use Fal\Stick\Security\UserInterface;
use Fal\Stick\Security\UserProviderInterface;

class User extends Mapper implements UserProviderInterface, UserInterface
{
    public function findByUsername($username): ?UserInterface
    {
        return $this->findOneByUsername($username)->found() ? $this : null;
    }

    public function findById($id): ?UserInterface
    {
        return $this->findOneById($id)->found() ? $this : null;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function getRoles(): array
    {
        return explode(',', (string) $this->roles);
    }

    public function isCredentialsExpired(): bool
    {
        return !$this->active;
    }
}
