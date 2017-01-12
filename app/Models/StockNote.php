<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A stock's note.
 *
 * @package Kaamaru\Forums\Core\Auth
 */
class StockNote extends Model
{
    /**
     * @var bool indicates if the model should be timestamped
     */
    public $timestamps = false;

    /**
     * @var string the primary key of the table
     */
    protected $primaryKey = 'symbol';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['symbol', 'note'];

    /**
     * @var string the database table used by the model
     */
    protected $table = 'stock_notes';
}