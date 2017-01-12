<?php namespace App\Repositories;

use App\Models\User;

/**
 * Deals with the users table.
 * 
 * @package App\Repositories
 */
class UserRepo
{
    /**
     * @var User the user model
     */
    protected $user;

    /**
     * @var array common fields to select from the user
     */
    protected $profileUserFields = [
        'id', 'first_name', 'last_name', 'about', 'email', 'group',
        'street1', 'street2', 'city', 'region', 'post_code', 'country',
        'mobile', 'home_phone', 'work_phone', 'created_at'
    ];

    /**
     * Initiate the User class.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get employees in pages.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateEmployees()
    {
        return $this->user
            ->where('group', '!=', 'Client')
            ->paginate(2);
    }

    /**
     * Get users in pages.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->user
            ->paginate(2);
    }

    /**
     * Get an employee or fail if not found.
     *
     * @param integer $userId
     * @return User
     */
    public function findOrFailEmployee($userId)
    {
        return $this->user
            ->select($this->profileUserFields)
            ->where('group', '!=', 'Client')
            ->findOrFail($userId);
    }

    /**
     * Get a user or fail if not found.
     *
     * @param integer $userId
     * @return User
     */
    public function findOrFailUser($userId)
    {
        return $this->user
            ->select($this->profileUserFields)
            ->findOrFail($userId);
    }

    /**
     * Get a user from for the edit form.
     *
     * @param integer $userId
     * @return User
     */
    public function getUserForForm($userId)
    {
        return $this->user
            ->select($this->profileUserFields)
            ->find($userId);
    }

    /**
     * Get a user by his/her id with all fields.
     *
     * @param integer $userId
     * @return User
     */
    public function getUserById($userId)
    {
        return $this->user->find($userId);
    }

    /**
     * Return a blank object of a new user.
     *
     * @return User
     */
    public function createNewUser()
    {
        return new User();
    }

    /**
     * Return all employees.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEmployees()
    {
        return $this->user->select('first_name', 'last_name', 'id')
            ->where('group', '!=', 'clients');
    }

    /**
     * Return employees' id and names.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEmployeesNames()
    {
        return $this->user
            ->orderBy('first_name')
            ->where('group', '!=', 'Client')
            ->get(['id', 'first_name', 'last_name']);
    }

    /**
     * Return clients' id and names.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getClientsNames()
    {
        return $this->user
            ->orderBy('first_name')
            ->where('group', 'Client')
            ->get(['id', 'first_name', 'last_name']);
    }

    /**
     * Get a user's name for the user stock page.
     *
     * @param integer $userId
     * @return User
     */
    public function getUserName($userId)
    {
        // Get user
        return $this->user
            ->select(['id', 'first_name', 'last_name', 'group'])
            ->find($userId);
    }
}