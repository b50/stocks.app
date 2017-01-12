<?php namespace App\Listeners;

use App\Models\User;
use Auth;
use Session;

/**
 * Allows us to perform actions on certain user events.
 *
 * @package App\Listeners
 */
class UserEventListener
{
    /**
     * Welcome the user back on login.
     *
     * @param User $user
     */
    public function onUserLogin($user)
    {
        $name = $user->first_name;
        Session::flash('message', "Welcome back $name!");
        Session::flash('status', 'info');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'auth.login',
            '\App\Listeners\UserEventListener@onUserLogin'
        );
    }

}