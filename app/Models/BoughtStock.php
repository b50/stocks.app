<?php namespace App\Models;


/**
 * Stocks that have been bought.
 */
class BoughtStock extends Stock
{
    /**
     * @var string the database table used by the model
     */
    protected $table = 'bought_stocks';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = [
        'symbol', 'employee_id', 'client_id', 'bought', 'amount', 'updated_at',
        'created_at',
    ];
    

    /**
     * Return red or green depending on change in price.
     *
     * @param integer $price price to compare with
     * @return string
     */
    public function colour($price)
    {
        return ($this->percentage($price) >= 0) ? 'green' : 'red';
    }

    /**
     * Return percentage change in price
     *
     * @param integer $price price to compare with
     * @return float|string
     */
    public function percentage($price)
    {
        $this->calculatePercentage($this->bought, $price);
    }

}