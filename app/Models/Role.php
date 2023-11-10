<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    public const ROLE_ADMIN = 'admin';

    public static function getAdmins()
    {
        return User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', self::ROLE_ADMIN)->toArray()
        );
    }
}
