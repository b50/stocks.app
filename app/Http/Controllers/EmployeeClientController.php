<?php namespace App\Http\Controllers;

use App\Models\EmployeeClient;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

/**
 * Deal with employee client relationships.
 *
 * @package App\Http\Controllers
 */
class EmployeeClientController extends Controller
{
    /**
     * @var UserRepo the userRepo model.
     */
    protected $userRepo;

    /**
     * @var EmployeeClient the employee client relationship model
     */
    protected $employeeClient;

    /**
     * Initiate the models.
     *
     * @param UserRepo $userRepo
     * @param EmployeeClient $employeeClient
     */
    public function __construct(UserRepo $userRepo, EmployeeClient $employeeClient)
    {
        $this->userRepo = $userRepo;
        $this->employeeClient = $employeeClient;
    }

    /**
     * Show add client form.
     *
     * @param integer $userId
     * @return \Illuminate\View\View
     */
    public function index($userId)
    {
        // Get user
        $user = $this->userRepo->getUserById($userId);

        // Get users
        $users = $this->userRepo->getClientsNames();

        return view('add-client', compact('user', 'users'));
    }

    /**
     * Remove client from an employee.
     *
     * @param integer $userId
     * @param integer $clientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userId, $clientId)
    {
        // Remove client
        $this->employeeClient->where([
            'employee_id' => $userId,
            'client_id' => $clientId,
        ])->delete();

        return redirect()
            ->action('UsersController@show', $userId)
            ->with('message', "Client removed.")
            ->with('status', 'success');
    }

    /**
     * Add a client to an employee.
     *
     * @param Request $request
     * @param integer $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $userId)
    {
        // Validation
        $clientValidation = [
            'required',
            'exists:users,id,group,Client',
            "unique:employee_clients,client_id,null,id,employee_id,$userId"
        ];
        $this->validate($request, [
            'clientId' => implode('|', $clientValidation),
        ], [
            'unique' => 'Client has already been added.',
            'exists' => 'Client does not exist.'
        ]);

        // Create client
        $this->employeeClient->create([
            'employee_id' => $userId,
            'client_id' => $request->input('clientId'),
        ]);

        // Redirect to the user
        return redirect()
            ->action('UsersController@show', $userId)
            ->with('message', "Client added.")
            ->with('status', 'success');
    }

}