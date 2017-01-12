<?php namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Fire on user events
 *
 * @package App\Observers
 */
class UserObserver {

    /**
     * Hash the password when saving a user
     *
     * @param User $model
     */
    public function saving($model)
    {
        // If the password is new, hash it.
        if ($model->isDirty('password')) {
            $model->password = Hash::make($model->password);
        }
    }

}