<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User \, Comment \): bool
    {
        return \->id === \->user_id;
    }
}
