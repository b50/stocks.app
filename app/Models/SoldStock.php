<?php namespace App\Models;


/**
 * A user's sold stocks.
 *
 * @package Kaamaru\Forums\Core\Auth
 */
class SoldStock extends Stock
{
    /**
     * @var string the database table used by the model.
     */
    protected $table = 'sold_stocks';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['symbol', 'employee_id', 'client_id', 'sold', 'from',
        'amount', 'updated_at', 'created_at'
    ];
    

    /**
     * Return red or green depending on change in price.
     *
     * @return string
     */
    public function colour()
    {
        return ($this->percentage() >= 0) ? 'green' : 'red';
    }

    /**
     * Return percentage change in price.
     *
     * @return float|string
     */
    public function percentage()
    {
        return $this->calculatePercentage($this->sold, $this->from);
    }
}