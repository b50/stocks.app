<?php namespace App\Models;

use App\Presenters\UserPresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Employee of the month.
 *
 * @package App\Models
 */
class EOTM
{
    /**
     * @var KeyValue EOTM values are stored in the key value table.
     */
    protected $keyValue;

    /**
     * @var User the user model
     */
    protected $userModel;

    /**
     * @var string store why this employee is employee of the month.
     */
    protected $eotm_why;

    /**
     * @var string the employee of the month
     */
    protected $user;

    /**
     * @var integer which month
     */
    protected $eotm_month;

    /**
     * @var integer the user id
     */
    protected $eotm_user_id;

    /**
     * Initiate employee of the month
     *
     * @param KeyValue $keyValue
     * @param User $user
     */
    public function __construct(KeyValue $keyValue, User $user)
    {
        $this->keyValue = $keyValue;
        $this->userModel = $user;
    }

    /**
     * Get the user.
     *
     * @return User
     */
    public function user()
    {
        if ( ! $this->user) {
            $this->user = $this->userModel
                ->select(['first_name', 'last_name', 'id'])
                ->find($this->userId());
        }

        return $this->user;
    }

    /**
     * Get the reason why they are employee of the month.
     *
     * @return KeyValue
     */
    public function why()
    {
        return $this->value('eotm_why');
    }

    /**
     * Return the user id
     *
     * @return int
     */
    public function userId()
    {
        return $this->value('eotm_user_id');
    }

    /**
     * Return the month
     *
     * @return mixed
     */
    public function month()
    {
        return $this->value('eotm_month');
    }

    /**
     * Update employee of the month.
     *
     * @param $userId
     * @param $why
     */
    public function update($userId, $why)
    {
        $this->keyValue->updateKey('eotm_user_id', $userId);
        $this->keyValue->updateKey('eotm_why', $why);
    }

    /**
     * Generate new employee of the month.
     */
    public function generateEmployeeOfMonth()
    {
        $profit = '(sold_stocks.sold - sold_stocks.from) * sold_stocks.amount';

        /* Select the stocks last month and find the employee who made
           the most profit. */
        $stock = SoldStock::select(['*', DB::raw("$profit as profit")])
            ->where(DB::raw('MONTH(created_at)'), '=',
                DB::raw('MONTH(CURRENT_DATE - INTERVAL 1 MONTH)'))
            ->orderBy('profit')
            ->groupBy('employee_id')
            ->first();

        // Update message
        if ($stock)
        {
            $name = $stock->employee->name();
            $message = "$name is the employee of the month ";
            $message .= "making a total of $$stock->profit!";
            $this->keyValue->where('key', '=', 'eotm_why')
                ->update(['value' => $message]);

            // Update user
            $this->keyValue->where('key', '=', 'eotm_user_id')
                ->update(['value' => $stock->employee->id]);

            $this->keyValue->where('key', '=', 'eotm_month')
                ->update(['value' => Carbon::now()->month]);
        }
    }

    /**
     * Get the value from the database.
     *
     * @param string $key
     * @return mixed
     */
    protected function value($key)
    {
        if ( ! $this->$key) {
            // Get key values
            $keyValues = $this->keyValue
                ->select(['key', 'value'])
                ->wherein('key', ['eotm_month', 'eotm_why', 'eotm_user_id'])
                ->get();

            // Save key values
            foreach ($keyValues as $keyValue) {
                $this->{$keyValue->key} = $keyValue->value;
            }
        }

        // return the right value
        return $this->$key;
    }

}
