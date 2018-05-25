<?php

declare(strict_types=1);

namespace App\Mapper;

use Fal\Stick\Security\UserInterface;
use Fal\Stick\Security\UserProviderInterface;
use Fal\Stick\Sql\Mapper;

class User extends Mapper implements UserProviderInterface, UserInterface
{
    public function findByUsername(string $username): ?UserInterface
    {
        return $this->loadByUsername($username);
    }

    public function findById(string $id): ?UserInterface
    {
        return $this->find($id);
    }

    public function page($page, $keyword, $cid)
    {
        $filter = ['id <>' => $cid];

        if ($keyword) {
            $filter[] = [
                'username ~' => '%'.$keyword.'%',
                '| id []' => '```(select user_id from profile where fullname like :username)',
            ];
        }

        return $this->paginate((int) $page, $filter);
    }

    public function profile()
    {
        return $this->hasOne('profile');
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return strval($this->fields['id']['value']);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->fields['username']['value'] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->fields['password']['value'] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return explode(',', $this->fields['roles']['value'] ?? '');
    }

    /**
     * {@inheritdoc}
     */
    public function isExpired(): bool
    {
        return !$this->fields['active']['value'];
    }
}
