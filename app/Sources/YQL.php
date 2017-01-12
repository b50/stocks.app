<?php namespace App\Sources;

/**
 * Send Yahoo query language requests to get Yahoo stock data.
 *
 * @package App\Sources
 */
class YQL extends Request
{
    /**
     * @var string the web address to get the data from.
     */
    protected $address = "https://query.yahooapis.com/v1/public/yql";

    /**
     * @var array options to send with the request
     */
    protected $options = [
        'format' => 'json',
        'env' => 'store://datatables.org/alltableswithkeys'
    ];

    /**
     * Get a stock quote from yahoo's servers.
     *
     * @param string $symbol
     * @return array
     */
    public function getStock($symbol)
    {
        // Build query
        $query = "select *
				  from yahoo.finance.quotes
 				  where symbol
 				  in ('$symbol')";


        // Run query
        $result = $this->runQuery(['q' => $query]);

        // Return result
        return $result->query->results->quote;
    }

}
