<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A user's favorite stocks.
 *
 * @package Kaamaru\Forums\Core\Auth
 */
class FavoriteStock extends Model
{
    /**
     * @var bool indicates if the model should be timestamped
     */
    public $timestamps = false;

    /**
     * @var string the database table used by the model
     */
    protected $table = 'favorite_stocks';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['symbol', 'user_id'];
}