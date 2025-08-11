<?php

namespace App\Repositories\Interface;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;
}
