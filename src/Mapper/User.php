<?php

namespace App\Mapper;

use Fal\Stick\Library\Security\UserInterface;
use Fal\Stick\Library\Security\UserProviderInterface;
use Fal\Stick\Library\Sql\Mapper;

class User extends Mapper implements UserProviderInterface, UserInterface
{
    public function findByUsername(string $username): ?UserInterface
    {
        return $this->loadByUsername($username);
    }

    public function findById(string $id): ?UserInterface
    {
        return $this->withId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return strval($this->get('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->get('username');
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->get('password');
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        $roles = $this->get('roles');

        return $roles ? explode(',', $roles) : array();
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsExpired(): bool
    {
        return !$this->get('active');
    }
}
