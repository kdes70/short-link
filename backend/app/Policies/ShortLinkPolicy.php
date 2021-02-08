<?php

namespace App\Policies;

use App\Models\ShortLink\ShortLink;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortLinkPolicy
{
    use HandlesAuthorization;

    public function author(User $user, ShortLink $shortLink): bool
    {
        if (is_null($user->id) || is_null($shortLink->user_id)) {
            return false;
        }

        return (int)$user->id === (int)$shortLink->user_id;
    }
}
