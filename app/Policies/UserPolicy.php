<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function modifyRole(User $user): bool
    {
        return $user->isAdmin();
    }
}
