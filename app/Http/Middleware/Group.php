<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Check a user is the right group.
 *
 * @package App\Http\Middleware
 */
class Group
{
    /**
     * @var Guard the Guard class used to authenticate users.
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $groups
     * @return mixed
     */
    public function handle($request, Closure $next, ...$groups)
    {
        // Get the user
        $user = $this->auth->user();

        // If the user is not in the list of groups
        if ( ! in_array($user->group, $groups)) {
            // Return unauthorized if an ajax request.
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                // Redirect to the user profile.
                return redirect()->action('UsersController@show', $user->id);
            }
        }

        // User is in the group, continue on with the request!
        return $next($request);
    }

}

