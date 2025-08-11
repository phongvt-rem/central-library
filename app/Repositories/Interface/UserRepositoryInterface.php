<?php

namespace App\Repositories\Interface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $userId): User;

    public function create(array $userData): User;

    public function update(int $userId, array $userData): User;
}
