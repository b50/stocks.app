<?php namespace App\Services;

use App\Models\Money;
use App\Sources\YQL;

/**
 * Buy and sell stocks.
 *
 * @package App\Services
 */
Class StockService
{
    /**
     * @var YQL Yahoo Query Language
     */
    protected $yql;

    /**
     * @var Money a client's money
     */
    protected $money;

    /**
     * Initiate the Money and YQL classes.
     *
     * @param YQL $yql
     * @param Money $money
     */
    public function __construct(YQL $yql, Money $money)
    {
        $this->yql = $yql;
        $this->money = $money;
    }

    /**
     * Buy a stock.
     *
     * @param StockRepo $stockRepo
     * @param array $input The request input
     * @return bool|integer
     */
    public function buyStock($stockRepo, $input)
    {
        /* Price taken using the server to stop incorrect
           prices from being submitted. */
        if ( ! $price = $this->yql->getStock($input['symbol'])->Ask) {
            return false;
        }

        // Update the client's money
        $money = -$price * $input['amount'];
        $clientMoney = $this->updateClient($input['client'], $money);

        // Check client has enough money
        if ($clientMoney->value < 0) {
            return false;
        } else {
            $clientMoney->save();
        }

        // Buy stock
        $stockRepo->buyStock([
            'bought' => $price,
            'symbol' => $input['symbol'],
            'employee_id' => \Auth::user()->id,
            'client_id' => $input['client'],
            'amount' => $input['amount'],
        ]);

        return $price;
    }

    /**
     * Sell a stock.
     *
     * @param StockRepo $stockRepo
     * @param array $input The request input
     * @return string the price of the sold stock
     */
    public function sellStock($stockRepo, $input)
    {
        /* Price taken using the server to stop incorrect
               prices from being submitted. */
        $price = $this->yql->getStock($input['symbol'])->Ask;

        // Get price of bought stock
        $stock = $stockRepo->getBoughtStockById($input['id']);

        // Update the client's money
        $money = $price * $input['amount'];
        $this->updateClient($stock->client_id, $money)->save();

        // Sell stocks
        $stockRepo->sellStock([
            'symbol' => $input['symbol'],
            'client_id' => $stock->client_id,
            'employee_id' => \Auth::user()->id,
            'amount' => min($input['amount'], $stock->amount),
            /* Price taken using the server to stop incorrect
               prices from being submitted. */
            'sold' => $price,
            'from' => $stock->bought
        ]);

        // All stocks sold
        if ($stock->amount == \Input::get('amount')) {
            $stock->delete();
        } else { // Some stock sold
            $stock->amount -= \Input::get('amount');
            $stock->save();
        }

        return $price;
    }

    /**
     * Update a client's money.
     *
     * @param integer $userId
     * @param integer $money
     * @return bool
     */
    protected function updateClient($userId, $money)
    {
        $clientMoney = $this->money->find($userId);
        $clientMoney->value += $money;
        return $clientMoney;
    }

}