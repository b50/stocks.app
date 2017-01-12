<?php namespace App\Http\Controllers;

use App\Models\FavoriteStock;
use App\Models\StockNote;
use App\Repositories\StockRepo;
use App\Services\StockService;
use App\Sources\YahooAutoComplete;
use Illuminate\Http\Request;

/**
 * Deals with stock actions. Anything /stocks/.
 *
 * @package App\Http\Controllers
 */
class StockController extends Controller
{
    /**
     * @var StockRepo StockRepo Used to manipulate stock data in the database.
     */
    protected $stockRepo;

    /**
     * @param StockRepo $stockRepo
     */
    public function __construct(StockRepo $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    /**
     * Show the bought stocks page.
     *
     * @return \Illuminate\View\View
     */
    public function boughtStocks()
    {
        $boughtStocks = $this->stockRepo->paginateboughtstocks();
        return view('bought-stocks', compact('boughtStocks'));
    }

    /**
     * Show the sold stocks page.
     *
     * @return \Illuminate\View\View
     */
    public function soldStocks()
    {
        $soldStocks = $this->stockRepo->paginateSoldStocks();
        return view('sold-stocks', compact('soldStocks'));
    }

    /**
     * Show a stock.
     *
     * @param StockNote $note
     * @param string $symbol
     * @return \Illuminate\View\View
     */
    public function show(StockNote $note, $symbol)
    {
        // Get stocks
        $boughtStocks = $this->stockRepo->getBoughtStocks($symbol);
        $soldStocks = $this->stockRepo->getSoldStocks($symbol);

        // Get the note for this stock
        $note = $note->select(['note'])->where('symbol', $symbol)->first();

        // Show stock page
        return view('stock', compact(
            'symbol',
            'soldStocks',
            'boughtStocks',
            'note'
        ));
    }

    /**
     * Buy stocks.
     *
     * @param Request $request
     * @param StockService $sService Buying and selling stocks.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request, StockService $sService)
    {
        $this->validateStock($request);

        // Buy Stocks
        $input = $request->input();
        $price = $sService->buyStock($this->stockRepo, $input);

        // Create status messages
        if ($price) {
            $message = $input['amount'] . " stocks were bought at $$price each";
            $status = 'success';
        } else {
            $message = "Failed to buy stocks. The market may be closed or the 
                        client may not have sufficient funds.";
            $status = 'danger';
        }

        // Redirect back to the stock page
        return redirect()
            ->action('StockController@show', ['symbol' => $input['symbol']])
            ->with('message', $message)->with('status', $status);
    }

    /**
     * Sell stocks.
     *
     * @param Request $request
     * @param StockService $sService Buying and selling stocks.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sell(Request $request, StockService $sService)
    {
        $this->validateStock($request);

        // Sell stocks
        $input = $request->input();
        $price = $sService->sellStock($this->stockRepo, $input);

        // Show message
        $message = $input['amount'] . " stocks were sold at $$price each";

        // Redirect back to stock page
        return redirect()
            ->action('StockController@show', ['symbol' => $input['symbol']])
            ->with('message', $message)->with('status', 'success');
    }

    public function search(YahooAutoComplete $yac, $query)
    {
        return response()->json($yac->search($query));
    }

    /**
     * Add or remove the stock as a favorite.
     *
     * @param Request $request
     * @param FavoriteStock $favoriteStock A favorite stock model.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favorite(Request $request, FavoriteStock $favoriteStock)
    {
        // Validate stock
        $this->validate($request, [
            'symbol' => 'required|max:10',
        ]);

        $symbol = $request->input('symbol');

        // Get favorite from the db
        $favorite = $favoriteStock->where('symbol', $symbol)
            ->where('user_id', $request->user()->id)
            ->first();

        // Favorite already exists so delete favorite
        if ($favorite) {
            $favorite->delete();
            $message = "$symbol has been removed from your favorites.";
        } else { // Create the favorite
            $favoriteStock->create([
                'symbol' => $symbol,
                'user_id' => $request->user()->id
            ]);
            $message = "$symbol has been added to your favorites.";
        }

        // Redirect to the stock page
        return redirect()
            ->action('StockController@show', ['symbol' => $symbol])
            ->with('message', $message)->with('status', 'success');
    }

    /**
     * Save a note.
     *
     * @param Request $request
     * @param StockNote $stockNote A stock note model.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveNote(Request $request, StockNote $stockNote)
    {
        $this->validate($request, [
            'symbol' => 'required|max:10',
            'note' => 'max:8000'
        ]);

        // Create or edit a stock note.
        $note = $stockNote->findornew($request->get('symbol'));
        $note->symbol = $request->get('symbol');
        $note->note = $request->get('note');
        $note->save();

        // Redirect to the stock page
        return redirect()
            ->action('StockController@show', $request->get('symbol'))
            ->with('message', "Note saved.")->with('status', 'success');
    }

    /**
     * Validate the stocks bought or sold.
     *
     * @param $request
     */
    protected function validateStock($request)
    {
        $this->validate($request, [
            'amount' => 'min:1|required|numeric',
            'client_id' => 'exists:users,id',
            'employee_id' => 'exists:users,id',
            'symbol' => 'required'
        ]);
    }

}