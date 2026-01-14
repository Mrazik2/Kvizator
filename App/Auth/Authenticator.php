<?php

namespace App\Auth;

use Framework\Auth\SessionAuthenticator;
use Framework\Core\IIdentity;
use App\Models\User;

class Authenticator extends SessionAuthenticator
{

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $user = User::getAll("username = ?", [$username])[0] ?? null;
        if ($user === null) {
            return null;
        }
        if (password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }
}