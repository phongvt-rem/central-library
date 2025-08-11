<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * The User model instance.
     *
     * @var User
     */
    protected $model;

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
     * @param int $id
     * @return User
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new user record.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing user by ID.
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }
}
