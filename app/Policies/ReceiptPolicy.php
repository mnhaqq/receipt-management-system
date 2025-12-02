<?php

namespace App\Policies;

use App\Models\Receipt;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReceiptPolicy
{
    public function modify(User $user, Receipt $receipt): Response
    {
        return $user->id === $receipt->user_id
            ? Response::allow()
            : Response::deny('You do not have access to modify receipt');
    }
}
