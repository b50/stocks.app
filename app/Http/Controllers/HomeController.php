<?php namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\EOTM;
use App\Repositories\StockRepo;
use Carbon\Carbon;

/**
 * Show Home Page
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Show Home Page
     *
     * @param EOTM $eotm the employee of the month
     * @param StockRepo $stocks the stocks repo to get bought and sold stocks
     * @param Announcement $announcement to get the latest announcement
     * @return \Illuminate\View\View
     */
    public function index(EOTM $eotm, StockRepo $stocks, Announcement $announcement)
    {
        // Recalculate Employee of the month
        if ($eotm->month() < Carbon::now()->month) {
            $eotm->generateEmployeeOfMonth();
        }

        // Get Announcements
        $announcements = $announcement
            ->select(['id', 'content', 'created_at', 'user_id'])
            ->latest('id')
            ->with('user')
            ->simplePaginate(1);

        // Get recent bought and sold stocks
        $stocksBought = $stocks->getRecentBoughtStocks();
        $stocksSold = $stocks->getRecentSoldStocks();

        return view('home', compact(
            'eotm',
            'announcements',
            'stocksBought',
            'stocksSold'
        ));
    }

}