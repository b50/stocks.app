<?php namespace App\Http\Controllers;

use App\Models\Money;
use App\Models\User;
use App\Repositories\StockRepo;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

/**
 * Show and edit users.
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var User the user model
     */
    protected $userRepo;

    /**
     * @param UserRepo $userRepo
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;

        // Protect areas from clients.
        $this->middleware('group:Admin,Employee', [
            'except' => ['index', 'show', 'edit', 'update', 'bought', 'sold']
        ]);
    }

    /**
     * Show users page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->user()->group == "Client") {
            // Don't allow clients to view other clients.
            $users = $this->userRepo->paginateEmployees();
        } else {
            $users = $this->userRepo->paginate();
        }
        return view('users', compact('users'));
    }

    /**
     * Show user profile
     *
     * @param StockRepo $stockRepo
     * @param Request $request
     * @param integer $userId A user's id
     * @return \Illuminate\View\View
     */
    public function show(StockRepo $stockRepo, Request $request, $userId)
    {
        // Get authenticated user from cache
        if ($request->user()->id == $userId) {
            $user = $request->user();
        } else { // Get user from the database
            // Get users who aren't clients
            if ($request->user()->group == "Client") {
                $user = $this->userRepo->findOrFailEmployee($userId);
            } else { // Get any user
               $user = $this->userRepo->findOrFailUser($userId);
            }
        }

        // Get stocks
        if (in_array($user->group, ["Employee", "Admin"])) {
            $boughtStocks = $stockRepo->getBoughtStockForEmployee($user->id);
            $soldStocks = $stockRepo->getSoldStockForEmployee($user->id);

            $user->load([
                'favoriteStocks' => function ($query) {
                    $query->take(5);
                    $query->latest('id');
                }
            ]);
        } else { // Add client stocks
            $boughtStocks = $stockRepo->getBoughtStockForClient($user->id);
            $soldStocks = $stockRepo->getSoldStockForClient($user->id);
        }

        return view('profile', compact('user', 'boughtStocks', 'soldStocks'));
    }

    /**
     * Show edit user form.
     *
     * @param Request $request
     * @param integer $userId A user's id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $userId)
    {
        $this->checkOwnerOrAdmin($request->user(), $userId);

        // Get user
        $user = $this->userRepo->getUserForForm($userId);

        return view('edit-profile', compact('user'));
    }

    /**
     * Edit a user.
     *
     * @param Request $request
     * @param integer $userId A user's id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $userId)
    {
        $this->checkOwnerOrAdmin($request->user(), $userId);

        // Get user
        $user = $this->userRepo->getUserById($userId);

        // Get validation
        $validation = $this->getValidation();

        // Don't check email against the database if it's the user's own email
        if ($request->get('email') == $user->email) {
            $validation['email'] = 'required|email|max:255';
        }

        $this->validate($request, $validation);

        // Edit personal info if allowed
        if ($request->user()->group == "Admin") {

            // Validate admin fields
            $this->validate($request, $this->getProtectedValidation());

            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->group = $request->get('group');

            if ($user->group == "Client") {
                $user->money->value = $request->get('money');
                $user->money->update();
            }
        }

        // Fill user with new info
        $user->fill(array_filter($request->input()));

        // Upload avatar if has one
        if ($request->hasFile('avatar')) {
            $request->file('avatar')
                ->move(public_path('images/users'), $user->id . ".jpg");
        }

        // Save user
        $user->save();

        // Clear cache so we show new data
        if ($userId == $request->user()->id) {
            \Cache::forget('user_by_token_' . $userId);
            \Cache::forget('user_by_id_' . $userId);
        }

        // Go back to profile
        return redirect()
            ->action('UsersController@show', compact('userId'))
            ->with('message', "Profile updated.")
            ->with('status', 'success');
    }

    /**
     * Show create user page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-user');
    }

    /**
     * Create the user.
     *
     * @param Request $request
     * @param Money $money a client's money
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Money $money)
    {
        $this->validate($request, array_merge(
            $this->getProtectedValidation(), $this->getValidation(),
            ['password' => 'required']
        ));

        // Create the user
        $user = $this->userRepo->createNewUser();
        $user->fill(array_filter($request->input()));

        // Add admin fields
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->group = $request->get('group');

        // Save user
        $user->save();

        // Add money
        if ($user->group == "Client") {
            $money->create([
               'client_id' => $user->id,
                'value' => $request->get('value')
            ]);
        }

        // Add avatar
        if ($request->hasFile('avatar')) {
            $request->file('avatar')
                ->move(public_path('images/users'), $user->id . ".jpg");
        }

        return redirect()
            ->action('UsersController@show', $user->id)
            ->with('message', "User created.")
            ->with('status', 'success');
    }

    /**
     * Make sure that only the owner or an admin can edit their profile.
     *
     * @param User $user A user object
     * @param integer $userId A user's id
     */
    protected function checkOwnerOrAdmin($user, $userId)
    {
        if ($user->group != "Admin" and $user->id != $userId) {
            abort(403);
        }
    }

    /**
     * Get user create/edit validation
     *
     * @return array
     */
    protected function getValidation()
    {
        return [
            'avatar' => 'image|max:1000',
            'password' => 'confirmed|min:6',
            'currentPassword' => 'auth|required',
            'about' => 'max:2000',
            'street1' => 'required|max:255',
            'street2' => 'max:255',
            'city' => 'max:255',
            'region' => 'max:255',
            'post_code' => 'required|max:50',
            'country' => 'required|max:80',
            'mobile' => 'max:50',
            'home_phone' => 'max:50',
            'work_phone' => 'max:50',
            'email' => 'required|email|max:255|unique:users',
            'money' => 'money'
        ];
    }

    /**
     * Get validation that only an admin can edit.
     *
     * @return array
     */
    protected function getProtectedValidation()
    {
        return [
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:70',
            'group' => 'required|in:Admin,Client,Employee'
        ];
    }

}