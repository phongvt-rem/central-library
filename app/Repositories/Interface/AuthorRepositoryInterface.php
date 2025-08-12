<?php

namespace App\Repositories\Interface;

use Illuminate\Support\Collection;

interface AuthorRepositoryInterface
{
    public function all(): Collection;
}
