<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * KeyValue represents the key value table. A table of key's and corresponding 
 * values.
 *
 * @package Kaamaru\Forums\Forums
 */
class KeyValue extends Model
{
    /**
     * @var bool indicates if the model should be timestamped
     */
    public $timestamps = false;

    /**
     * @var string the database table used by the model
     */
    protected $table = 'key_value';

    /**
     * Update a record in the table.
     *
     * @param $key
     * @param $value
     */
    public function updateKey($key, $value)
    {
        $this->where('key', $key)->update(['value' => $value]);
    }
}