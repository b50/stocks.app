<?php namespace App\Http\Controllers;

use App\Models\EOTM;
use App\Models\User;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

/**
 * Edit the employee of the month.
 *
 * Class AnnouncementController
 * @package App\Http\Controllers
 */
class EOTMController extends Controller
{
    /**
     * @var EOTM Employee of the month model
     */
    protected $eotm;

    /**
     * Initiate the EOTM model.
     *
     * @param EOTM $eotm
     */
    public function __construct(EOTM $eotm)
    {
        $this->eotm = $eotm;
    }

    /**
     * Show employee of the month edit page.
     *
     * @param UserRepo $userRepo
     * @return \Illuminate\View\View
     */
    public function edit(UserRepo $userRepo)
    {
        $employees = $userRepo->getEmployeesNames();
        return view('edit-eotm', [
            'eotm' => $this->eotm,
            'employees' => $employees
        ]);
    }

    /**
     * Edit employee of the month.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'why' => 'required|max:300',
            'user_id' => 'required|no-client-exists']
        );

        // Update eotm
       $this->eotm->update($request->input('user_id'), $request->input('why'));

        return redirect()
            ->action('HomeController@index')
            ->with('message', "Employee of the month updated.")
            ->with('status', 'success');
    }
}