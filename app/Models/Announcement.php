<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * An announcement.
 *
 * Shows on the home page.
 *
 * @package App\Models
 */
class Announcement extends Model
{
    /**
     * @var string the database table used by the model
     */
    protected $table = 'announcements';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = ['user_id', 'content'];

    /**
     * Employee relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this
            ->HasOne('\App\Models\User', 'id', 'user_id')
            ->select(['first_name', 'last_name', 'id']);
    }

}