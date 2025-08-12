<?php

namespace App\Repositories\Interface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $user_id): User;

    public function create(array $user_data): User;

    public function update(int $user_id, array $user_data): User;
}
