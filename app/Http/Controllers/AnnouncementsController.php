<?php namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Edit and create announcements.
 *
 * Class AnnouncementController
 * @package App\Http\Controllers
 */
class AnnouncementsController extends Controller
{
    /**
     * @var Announcement the announcement model.
     */
    protected $announcement;

    /**
     * Initiate the announcement model
     *
     * @param Announcement $announcement
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Edit an announcement.
     *
     * @param integer $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);
        return view('edit-announcement', compact('announcement'));
    }

    /**
     * Show the create announcement page.
     *
     *  @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create-announcement');
    }

    /**
     * Update the announcement.
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the announcement
        $this->validate($request, ['content' => 'required|max:255']);

        // Get user
        $announcement = Announcement::find($id);

        // Update announcement
        $announcement->content = Input::get('content');
        $announcement->save();

        // Redirect to the home page
        return redirect()
            ->action('HomeController@index')
            ->with('message', "Announcement updated.")
            ->with('status', 'success');
    }

    /**
     * Store an announcement.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the announcement
        $this->validate($request, ['content' => 'required|max:254']);

        // Update announcement
        Announcement::create([
            'content' => $request->get('content'),
            'user_id' => $request->user()->id
        ]);

        // Redirect to the home page
        return redirect()
            ->action('HomeController@index')
            ->with('message', "Announcement created.")
            ->with('status', 'success');
    }
}

