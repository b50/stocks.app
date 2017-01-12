<?php namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * The user.
 *
 * @package App\Models
 */
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * @var string the database table used by the model
     */
    protected $table = 'users';

    /**
     * @var array the attributes that are mass assignable
     */
    protected $fillable = [
        'about', 'email', 'password', 'about', 'street1', 'street2', 'city',
        'post_code', 'region', 'country', 'mobile', 'home_phone', 'work_phone'
    ];

    /**
     * @var array the attributes excluded from the model's JSON form
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Run the user observer.
     */
    public static function boot()
    {
        self::observe(new UserObserver);
        parent::boot();
    }

    /**
     * Clients relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function clients()
    {
        return $this->hasmany(EmployeeClient::class, 'employee_id', 'id')
            ->join('users', 'employee_clients.client_id', '=', 'users.id')
            ->select(['first_name', 'last_name', 'id']);
    }

    /**
     * Employees relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function employees()
    {
        return $this->hasmany(EmployeeClient::class, 'client_id', 'id')
            ->join('users', 'employee_clients.employee_id', '=', 'users.id')
            ->select(['first_name', 'last_name', 'id']);
    }

    /**
     * Favorite stocks relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoriteStocks()
    {
        return $this->hasmany(FavoriteStock::class, 'user_id', 'id')
            ->select(['symbol', 'user_id']);
    }

    /**
     * Show if a stock is in a user's favorites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function favoriteStock($symbol)
    {
        return $this->hasOne(FavoriteStock::class, 'user_id', 'id')
            ->where('symbol', $symbol)
            ->count();
    }

    /**
     * Client Money relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function money()
    {
        return $this
            ->hasOne(Money::class, 'client_id')
            ->select(['client_id', 'value']);
    }

    /**
     * Return the user's avatar.
     *
     * @return string
     */
    public function avatar()
    {
        $imageDir = 'images/users/';
        $image = $this->id . '.jpg';

        if (file_exists($imageDir . $image)) {
            return '/' . $imageDir . $image;
        }
        return '/' . $imageDir . 'no-avatar.jpg';
    }

    /**
     * Return the user's name.
     *
     * @return string
     */
    public function name()
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * Return correctly formatted about.
     *
     * @return string
     */
    public function aboutBr()
    {
        return nl2br(e($this->about));
    }

}
