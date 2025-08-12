<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected User $model;

    /**
     * Constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Find a user by ID or fail.
     *
     * @param int $user_id
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($user_id): User
    {
        return $this->model->findOrFail($user_id);
    }

    /**
     * Create a new user record.
     *
     * @param array $user_data
     * @return User
     */
    public function create(array $user_data): User
    {
        return $this->model->create($user_data);
    }

    /**
     * Update an existing user by ID.
     *
     * @param int $user_id
     * @param array $user_data
     * @return User
     */
    public function update($user_id, array $user_data): User
    {
        $user = $this->find($user_id);
        $user->update($user_data);

        return $user;
    }
}
