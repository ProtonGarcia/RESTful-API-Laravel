<?php

namespace App\Policies;

use App\Traits\adminActions;
use App\Traits\AdminActions as TraitsAdminActions;
use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization, TraitsAdminActions;

    /**
     * Determine whether the user can view the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction $transaction)
    {
        return $user->id === $transaction->buyer->id || $user->id === $transaction->product->seller->id;
    }

}
