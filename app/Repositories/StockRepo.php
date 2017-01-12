<?php namespace App\Repositories;

use App\Models\BoughtStock;
use App\Models\SoldStock;

/**
 * Deals with the bought and sold stocks table.
 *
 * @package App\Repositories
 */
class StockRepo
{
    /**
     * @var BoughtStock
     */
    protected $boughtStock;

    /**
     * @var SoldStock
     */
    protected $soldStock;

    /**
     * Initiate the BoughtStock and SoldStock classes.
     *
     * @param BoughtStock $bought
     * @param SoldStock $sold
     */
    public function __construct(BoughtStock $bought, SoldStock $sold)
    {
        $this->boughtStock = $bought;
        $this->soldStock = $sold;
    }

    /**
     * Get recent sold stocks for homepage
     */
    public function getRecentSoldStocks()
    {
        return $this->soldStock
            ->select([
                'symbol', 'sold', 'amount', 'employee_id', 'created_at',
                'from'
            ])
            ->take(5)
            ->with('employee')
            ->latest()
            ->get();
    }

    /**
     * Get recent bought stocks for homepage
     */
    public function getRecentBoughtStocks()
    {
        return $this->boughtStock
            ->select([
                'symbol', 'amount', 'employee_id', 'created_at', 'bought'
            ])
            ->take(5)
            ->with('employee')
            ->latest()
            ->get();
    }

    /**
     * Get bought stock to show on an employee profile.
     *
     * @param integer $employee_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBoughtStockForEmployee($employee_id)
    {
        return $this->boughtStock->where('employee_id', $employee_id)
            ->select([
                'symbol', 'amount', 'client_id', 'created_at', 'bought'
            ])
            ->take(5)
            ->with('client')
            ->latest()
            ->get();
    }

    /**
     * Get sold stock to show on an employee profile.
     *
     * @param integer $employee_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSoldStockForEmployee($employee_id)
    {
        return $this->soldStock->where('employee_id', $employee_id)
            ->select([
                'symbol', 'amount', 'client_id', 'created_at', 'sold', 'from'
            ])
            ->take(5)
            ->with('client')
            ->latest()
            ->get();
    }

    /**
     * Get bought stock to show on a client profile.
     *
     * @param integer $client_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBoughtStockForClient($client_id)
    {
        return $this->boughtStock->where('client_id', $client_id)
            ->select([
                'symbol', 'amount', 'employee_id', 'created_at', 'bought'
            ])
            ->take(5)
            ->with('employee')
            ->latest()
            ->get();
    }

    /**
     * Get sold stock to show on a client profile.
     *
     * @param integer $client_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSoldStockForClient($client_id)
    {
        return $this->soldStock->where('client_id', $client_id)
            ->take(5)
            ->with('employee')
            ->latest()
            ->get([
                'symbol', 'amount', 'employee_id', 'created_at', 'sold', 'from'
            ]);
    }

    /**
     * Paginate bought stock for employee profile.
     *
     * @param integer $employee_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateBoughtStockForEmployee($employee_id)
    {
        return $this->boughtStock
            ->select([
                'symbol', 'amount', 'client_id', 'created_at', 'bought'
            ])
            ->where('employee_id', $employee_id)
            ->with('client')
            ->paginate(2);
    }

    /**
     * Paginate sold stock for employee profile.
     *
     * @param integer $employee_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateSoldStockForEmployee($employee_id)
    {
        return $this->soldStock
            ->select([
                'symbol', 'amount', 'client_id', 'created_at', 'sold', 'from'
            ])
            ->where('employee_id', $employee_id)
            ->with('client')
            ->paginate(2);
    }

    /**
     * Paginate bought stock for client profile.
     *
     * @param integer $client_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateBoughtStockForClient($client_id)
    {
        return $this->boughtStock
            ->select([
                'symbol', 'amount', 'employee_id', 'created_at', 'bought'
            ])
            ->where('client_id', $client_id)
            ->with('employee')
            ->paginate(2);
    }

    /**
     * Paginate sold stock for client profile.
     *
     * @param integer $client_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateSoldStockForClient($client_id)
    {
        return $this->soldStock
            ->select([
                'symbol', 'amount', 'employee_id', 'created_at', 'sold', 'from'
            ])
            ->where('client_id', $client_id)
            ->with('employee')
            ->paginate(2);
    }

    /**
     * Paginate bought stocks.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateBoughtStocks()
    {
        return $this->boughtStock
            ->select([
                'symbol', 'amount', 'employee_id', 'client_id', 'created_at',
                'bought'
            ])
            ->with('employee', 'client')
            ->paginate(2);
    }

    /**
     * Paginate sold stocks.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateSoldStocks()
    {
        return $this->soldStock
            ->select([
                'symbol', 'amount', 'employee_id', 'client_id', 'created_at',
                'sold', 'from'
            ])
            ->with('employee', 'client')
            ->paginate(2);
    }

    /**
     * Get bought stocks for a symbol.
     *
     * @param string $symbol
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getBoughtStocks($symbol)
    {
        return $this->boughtStock
            ->where('symbol', $symbol)
            ->get(['id', 'symbol', 'amount', 'created_at', 'bought']);
    }

    /**
     * Get sold stocks for a symbol.
     *
     * @param string $symbol
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSoldStocks($symbol)
    {
        return $this->soldStock
            ->where('symbol', $symbol)
            ->get(['symbol', 'amount', 'created_at', 'sold', 'from']);
    }

    /**
     * Get one sold stock.
     *
     * @param $id id of the stock
     * @return BoughtStock
     */
    public function getBoughtStockById($id)
    {
        return $this->boughtStock->where('id', $id)
            ->first(['id', 'bought', 'amount', 'client_id']);
    }

    /**
     * Buy a stock.
     *
     * @param array $attributes
     * @return static
     */
    public function buyStock($attributes)
    {
        return $this->boughtStock->create($attributes);
    }

    /**
     * Sell a stock.
     *
     * @param array $attributes
     * @return static
     */
    public function sellStock($attributes)
    {
        return $this->soldStock->create($attributes);
    }
}