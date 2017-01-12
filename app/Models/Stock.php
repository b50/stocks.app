<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Base class for bought and sold stocks.
 *
 * @package App\Presenters
 */
Abstract Class Stock extends Model{

    /**
     * Employee relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this
            ->HasOne('\App\Models\User', 'id', 'employee_id')
            ->select(['first_name', 'last_name', 'id']);
    }

    /**
     * Client relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this
            ->HasOne('\App\Models\User', 'id', 'client_id')
            ->select(['first_name', 'last_name', 'id']);
    }

    /**
     * Return percentage change in price.
     *
     * @param $current
     * @param $compare
     * @return float|string
     */
    protected function calculatePercentage($current, $compare)
    {
        // Calculate percentage
        $percentage = round(($current - $compare) / $current * 100, 2);

        // Add + if positive
        if ($percentage > 0) {
            $percentage = '+' . $percentage;
        }

        return $percentage;
    }

}
