<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A linking table between the employee and the client
 * to maintain referential integrity.
 *
 * @package Kaamaru\Forums\Core\Auth
 */
class EmployeeClient extends Model
{
    /**
     * @var bool indicates if the model should be timestamped
     */
    public $timestamps = false;

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['employee_id', 'client_id'];

    /**
     * @var string the database table used by the model.
     */
    protected $table = 'employee_clients';
}