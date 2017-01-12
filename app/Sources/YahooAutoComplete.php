<?php namespace App\Sources;

/**
 * Get Yahoo symbol suggestions.
 *
 * @package App\Sources
 */
class YahooAutoComplete extends Request
{
    /**
     * @var string the web address to get the data from.
     */
    protected $address = "https://s.yimg.com/aq/autoc";
    
    /**
     * @var array options to send with the request
     */
    protected $options = [
        'region' => 'gb',
        'lang' => 'en-gb'
    ];

    public function search($query)
    {
       return $this->runQuery(['query' => $query]);
    }
}
