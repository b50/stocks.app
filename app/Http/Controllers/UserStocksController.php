<?php namespace App\Http\Controllers;

use App\Repositories\StockRepo;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;

/**
 * Show a user's bought and sold stocks.
 *
 * @package App\Http\Controllers
 */
class UserStocksController extends Controller
{
    /**
     * @var UserRepo the userRepo model
     */
    protected $userRepo;

    /**
     * @var StockRepo the StockRepo model
     */
    protected $stockRepo;

    /**
     * Instantiate a new UserController instance.
     *
     * @param StockRepo $stockRepo
     * @param UserRepo $userRepo
     */
    public function __construct(StockRepo $stockRepo, UserRepo $userRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Show the sold stocks.
     *
     * @param Request $request
     * @param integer $userId
     * @return \Illuminate\View\View
     */
    public function sold(Request $request, $userId)
    {
        $this->checkClient($request->user(), $userId);

        // Get user
        $user = $this->userRepo->getUserName($userId);

        // Get stocks
        if ($user->group == "Client") {
            $stocks = $this->stockRepo->paginateSoldStockForClient($userId);
        } else {
            $stocks = $this->stockRepo->paginateSoldStockForEmployee($userId);
        }

        return view('user-sold', compact('user', 'stocks'));
    }

    /**
     * Show the bought stocks page.
     *
     * @param Request $request
     * @param integer $userId
     * @return \Illuminate\View\View
     */
    public function bought(Request $request, $userId)
    {
        // Get user
        $user = $this->userRepo->getUserName($userId);

        $this->checkClient($request->user(), $userId);

        // Get stocks
        if ($user->group == "Client") {
            $stocks = $this->stockRepo->paginateBoughtStockForClient($userId);
        } else {
            $stocks = $this->stockRepo->paginateBoughtStockForEmployee($userId);
        }

        return view('user-bought', compact('user', 'stocks'));
    }

    /**
     * Make sure a client can only view their own info
     *
     * @param $user
     * @param $userId
     */
    protected function checkClient($user, $userId)
    {
        if ($user->group == "Client" and $user->id != $userId) {
            abort(403);
        }
    }

}