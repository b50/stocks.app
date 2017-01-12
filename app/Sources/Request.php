<?php namespace App\Sources;

use GuzzleHttp\Client;

/**
 * Uses Guzzle to send HTTP requests.
 *
 * @package App\Sources
 */
class Request
{
    /**
     * @var string the web address to get the data from.
     */
    protected $address = "";

    /**
     * @var array options to send with the request
     */
    protected $options = [];

    /**
     * Run query on Yahoo servers and return the result as an array.
     *
     * @param array $query
     * @return array
     */
    protected function runQuery(Array $query)
    {
        // Add sql query to options
        $options = array_merge($this->options, $query);

        // Build and run request
        $request = new Client();
        $request = $request->get($this->address, ['query' => $options]);

        // Convert json to an object
        return json_decode($request->getBody());
    }
}
