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
     * @param int $userId
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($userId): User
    {
        return $this->model->findOrFail($userId);
    }

    /**
     * Create a new user record.
     *
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User
    {
        return $this->model->create($userData);
    }

    /**
     * Update an existing user by ID.
     *
     * @param int $userId
     * @param array $userData
     * @return User
     */
    public function update($userId, array $userData): User
    {
        $user = $this->find($userId);
        $user->update($userData);

        return $user;
    }
}
