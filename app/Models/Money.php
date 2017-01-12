<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A client's money
 *
 * @package Kaamaru\Forums\Forums
 */
class Money extends Model
{
    /**
     * @var bool indicates if the model should be timestamped
     */
    public $timestamps = false;

    /**
     * @var bool indicates if the model's primary key should increment
     */
    public $incrementing = false;

    /**
     * @var string the database table used by the model
     */
    protected $table = 'money';

    /**
     * @var string the primary key of the table
     */
    protected $primaryKey = 'client_id';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['client_id', 'value'];

}