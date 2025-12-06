<?php

namespace App\Auth;

use Framework\Auth\DummyAuthenticator;
use Framework\Auth\SessionAuthenticator;
use Framework\Core\IIdentity;
use App\Models\User;

class Authenticator extends SessionAuthenticator
{

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $user = User::getOne($username);
        if ($user === null) {
            return null;
        }
        if (password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }
}