<?php namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

/**
 * Used to cache authenticated user details for 10 minutes.
 *
 * @package App\Providers
 */
class CachedEloquentUserProvider extends EloquentUserProvider
{
    /**
     * @inheritdoc
     */
    public function retrieveByToken($identifier, $token)
    {
        return \Cache::remember('user_by_token_' . $identifier, 10,
            function () use ($identifier, $token) {
                return parent::retrieveByToken($identifier, $token);
            }
        );
    }
    
    /**
     * @inheritdoc
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();
        return \Cache::remember('user_by_id_' . $identifier, 10,
            function () use ($identifier) {
                return parent::retrieveById($identifier);
            });
    }

}