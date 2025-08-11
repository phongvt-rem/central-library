<?php

namespace App\Repositories\Interface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $id): User;

    public function create(array $data): User;

    public function update(int $id, array $data): User;
}
